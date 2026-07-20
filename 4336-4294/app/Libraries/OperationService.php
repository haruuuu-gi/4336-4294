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
    protected string $ownPrefix = '039';

    public function depot(int $compteId, float $montant)
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
            'commission' => 0,
            'solde_apres' => $compte['solde'],
        ]);
    }

    public function retrait(int $compteId, float $montant)
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
            'commission' => 0,
            'solde_apres' => $compte['solde'],
        ]);
    }

    public function transfert(int $compteId, string $telephoneDest, float $montant, bool $inclureFraisDest = false)
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

        if (! preg_match('/^\d{9,10}$/', $telephoneDest)) {
            throw new RuntimeException('Numéro destinataire invalide.');
        }

        $prefixDest = substr($telephoneDest, 0, 3);
        $transferFee = $baremeModel->fraisPour((int) $type['id'], $montant);
        $commission = 0.0;

        if ($prefixDest !== $this->ownPrefix && ! $prefixModel->where('prefixe', $prefixDest)->where('actif', 1)->first()) {
            throw new RuntimeException('Opérateur destinataire non pris en charge.');
        }

        if ($prefixDest !== $this->ownPrefix) {
            $commissionPercent = $prefixModel->commissionPourPrefixe($prefixDest);
            $commission = round($montant * ($commissionPercent / 100.0), 2);
        }

        $sender = $compteModel->findWithTelephone($compteId);
        if (! $sender) {
            throw new RuntimeException('Compte émetteur introuvable.');
        }

        if ($telephoneDest === $sender['telephone']) {
            throw new RuntimeException('Le destinataire doit être différent de l\'émetteur.');
        }

        if ($prefixDest !== $this->ownPrefix) {
            $totalFrais = $transferFee + $commission;
            $totalDebiter = $montant + $totalFrais;

            if ($sender['solde'] < $totalDebiter) {
                throw new RuntimeException('Solde insuffisant pour couvrir le montant et les frais.');
            }

            $compteModel->debiter($compteId, $totalDebiter);
            $compteAfter = $compteModel->find($compteId);

            $operationModel->insert([
                'compte_id' => $compteId,
                'compte_dest_id' => null,
                'telephone_dest' => $telephoneDest,
                'operation_type_id' => $type['id'],
                'montant' => $montant,
                'frais' => $transferFee,
                'commission' => $commission,
                'solde_apres' => $compteAfter['solde'],
            ]);

            return;
        }

        $retraitType = $typeModel->findByCode('retrait');
        $withdrawalFee = $retraitType ? $baremeModel->fraisPour((int) $retraitType['id'], $montant) : 0.0;

        $creditToDest = $montant;
        $totalDebiter = $montant + $transferFee;
        $fraisOperateur = $transferFee;

        if ($inclureFraisDest) {
            $creditToDest += $withdrawalFee;
            $totalDebiter += $withdrawalFee;
            $fraisOperateur += $withdrawalFee;
        }

        if ($sender['solde'] < $totalDebiter) {
            throw new RuntimeException('Solde insuffisant pour couvrir le montant et les frais.');
        }

        $destCompte = $compteModel->trouverOuCreer($telephoneDest);
        $compteModel->debiter($compteId, $totalDebiter);
        $compteAfter = $compteModel->find($compteId);

        $compteModel->crediter((int) $destCompte['id'], $creditToDest);
        $destAfter = $compteModel->find((int) $destCompte['id']);

        $operationModel->insert([
            'compte_id' => $compteId,
            'compte_dest_id' => $destCompte['id'] ?? null,
            'telephone_dest' => $telephoneDest,
            'operation_type_id' => $type['id'],
            'montant' => $creditToDest,
            'frais' => $fraisOperateur,
            'commission' => 0,
            'solde_apres' => $compteAfter['solde'],
        ]);

        $operationModel->insert([
            'compte_id' => $destCompte['id'] ?? null,
            'compte_dest_id' => $compteId,
            'telephone_dest' => $sender['telephone'],
            'operation_type_id' => $type['id'],
            'montant' => $creditToDest,
            'frais' => 0,
            'commission' => 0,
            'solde_apres' => $destAfter['solde'],
        ]);
    }
}
