<?php

namespace App\Libraries;

use App\Models\BaremeModel;
use App\Models\CompteModel;
use App\Models\OperationModel;
use App\Models\OperationTypeModel;
use App\Models\PrefixModel;
use RuntimeException;

class OperationService
{
    protected string $ownPrefix = '033';

    public function depot(int $compteId, float $montant): void
    {
        if ($montant <= 0) {
            throw new RuntimeException('Le montant doit être positif.');
        }

        $compteModel = new CompteModel();
        $operationModel = new OperationModel();
        $typeModel = new OperationTypeModel();

        $type = $typeModel->findByCode('depot');
        if (! $type) {
            throw new RuntimeException('Type d\'operation dépôt introuvable.');
        }

        $compteModel->crediter($compteId, $montant);

        $compte = $compteModel->find($compteId);

        $operationModel->insert([
            'compte_id' => $compteId,
            'compte_dest_id' => null,
            'operation_type_id' => $type['id'],
            'montant' => $montant,
            'frais' => 0,
            'solde_apres' => $compte['solde'],
        ]);
    }

    public function retrait(int $compteId, float $montant): void
    {
        if ($montant <= 0) {
            throw new RuntimeException('Le montant doit être positif.');
        }

        $compteModel = new CompteModel();
        $baremeModel = new BaremeModel();
        $operationModel = new OperationModel();
        $typeModel = new OperationTypeModel();

        $type = $typeModel->findByCode('retrait');
        if (! $type) {
            throw new RuntimeException('Type d\'operation retrait introuvable.');
        }

        $frais = $baremeModel->fraisPour((int) $type['id'], $montant);

        $compte = $compteModel->find($compteId);
        if (! $compte) {
            throw new RuntimeException('Compte introuvable.');
        }

        $total = $montant + $frais;
        if ($compte['solde'] < $total) {
            throw new RuntimeException('Solde insuffisant.');
        }

        $compteModel->debiter($compteId, $total);

        $compte = $compteModel->find($compteId);

        $operationModel->insert([
            'compte_id' => $compteId,
            'compte_dest_id' => null,
            'operation_type_id' => $type['id'],
            'montant' => $montant,
            'frais' => $frais,
            'solde_apres' => $compte['solde'],
        ]);
    }

    public function transfert(int $compteId, string $telephoneDest, float $montant, bool $inclureFraisDest = false): void
    {
        if ($montant <= 0) {
            throw new RuntimeException('Le montant doit être positif.');
        }

        $compteModel = new CompteModel();
        $baremeModel = new BaremeModel();
        $operationModel = new OperationModel();
        $typeModel = new OperationTypeModel();
        $prefixModel = new PrefixModel();

        $type = $typeModel->findByCode('transfert');
        if (! $type) {
            throw new RuntimeException('Type d\'operation transfert introuvable.');
        }

        if (! preg_match('/^\d{3,}$/', $telephoneDest)) {
            throw new RuntimeException('Numéro destinataire invalide.');
        }

        $prefixDest = substr($telephoneDest, 0, 3);

        if (! preg_match('/^03\d$/', $prefixDest)) {
            throw new RuntimeException('Préfixe du destinataire invalide pour les opérateurs 03x.');
        }

        $baseFrais = $baremeModel->fraisPour((int) $type['id'], $montant);

        $commission = 0.0;
        if ($prefixDest !== $this->ownPrefix) {
            $commissionPercent = $prefixModel->commissionPourPrefixe($prefixDest);
            $commission = round($montant * ($commissionPercent / 100.0), 2);
        }

        $totalFrais = $baseFrais + $commission;

        $compte = $compteModel->find($compteId);
        if (! $compte) {
            throw new RuntimeException('Compte émetteur introuvable.');
        }

        $totalDebiter = $montant + $totalFrais;
        if ($compte['solde'] < $totalDebiter) {
            throw new RuntimeException('Solde insuffisant pour couvrir le montant et les frais.');
        }

        // If destination is another operator, do NOT create or credit a local account.
        if ($prefixDest !== $this->ownPrefix) {
            // debit sender by montant + totalFrais (baseFrais + commission)
            $compteModel->debiter($compteId, $totalDebiter);
            $compteAfter = $compteModel->find($compteId);

            // Record operation with no local destination account; keep destination phone for reporting
            $operationModel->insert([
                'compte_id' => $compteId,
                'compte_dest_id' => null,
                'telephone_dest' => $telephoneDest,
                'operation_type_id' => $type['id'],
                'montant' => $montant,
                'frais' => $baseFrais,
                'commission' => $commission,
                'solde_apres' => $compteAfter['solde'],
            ]);

            return;
        }

        // Destination is internal: find or create dest account and credit accordingly
        $destCompte = $compteModel->trouverOuCreer($telephoneDest);

        $compteModel->debiter($compteId, $totalDebiter);
        $compteAfter = $compteModel->find($compteId);

        // If include fees option is set, add the baseFrais to the recipient's credited amount
        $creditToDest = $montant;
        if ($inclureFraisDest) {
            $creditToDest += $baseFrais;
        }

        $compteModel->crediter((int) $destCompte['id'], $creditToDest);
        $destAfter = $compteModel->find((int) $destCompte['id']);

        // Sender operation (outgoing)
        $operationModel->insert([
            'compte_id' => $compteId,
            'compte_dest_id' => $destCompte['id'] ?? null,
            'telephone_dest' => $telephoneDest,
            'operation_type_id' => $type['id'],
            'montant' => $montant,
            'frais' => $baseFrais,
            'commission' => 0,
            'solde_apres' => $compteAfter['solde'],
        ]);

        // Recipient operation (incoming) - frais zero for recipient
        $operationModel->insert([
            'compte_id' => $destCompte['id'] ?? null,
            'compte_dest_id' => $compteId,
            'telephone_dest' => $telephoneDest,
            'operation_type_id' => $type['id'],
            'montant' => $creditToDest,
            'frais' => 0,
            'commission' => 0,
            'solde_apres' => $destAfter['solde'],
        ]);
    }
}
