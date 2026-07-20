<?php

namespace App\Models;

use CodeIgniter\Model;

class CompteModel extends Model
{
    protected $table = 'comptes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['client_id', 'solde'];

    public function parClientId(int $clientId): ?array
    {
        return $this->where('client_id', $clientId)->first();
    }

    public function parTelephone(string $telephone): ?array
    {
        return $this->select('comptes.*, clients.telephone')
                    ->join('clients', 'clients.id = comptes.client_id')
                    ->where('clients.telephone', $telephone)
                    ->first();
    }

    public function trouverOuCreer(string $telephone): array
    {
        $clientModel = new ClientModel();
        $client = $clientModel->parTelephone($telephone);

        if ($client === null) {
            $clientId = $clientModel->insert(['telephone' => $telephone], true);
        } else {
            $clientId = $client['id'];
        }

        $compte = $this->parClientId($clientId);

        if ($compte === null) {
            $compteId = $this->insert(['client_id' => $clientId, 'solde' => 0], true);
            $compte = $this->find($compteId);
        }

        $compte['telephone'] = $telephone;

        return $compte;
    }

    public function crediter(int $compteId, float $montant): void
    {
        $this->set('solde', 'solde + ' . (float) $montant, false)
             ->where('id', $compteId)
             ->update();
    }

    public function debiter(int $compteId, float $montant): void
    {
        $this->set('solde', 'solde - ' . (float) $montant, false)
             ->where('id', $compteId)
             ->update();
    }
}
