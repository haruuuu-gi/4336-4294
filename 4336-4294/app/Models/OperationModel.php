<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table = 'operations';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'compte_id', 'compte_dest_id', 'operation_type_id',
        'montant', 'frais', 'solde_apres',
    ];

    public function historiquePourCompte(int $compteId): array
    {
        return $this->select('operations.*, operation_types.libelle as operation_libelle, cl2.telephone as telephone_dest')
                    ->join('operation_types', 'operation_types.id = operations.operation_type_id')
                    ->join('comptes c2', 'c2.id = operations.compte_dest_id', 'left')
                    ->join('clients cl2', 'cl2.id = c2.client_id', 'left')
                    ->where('operations.compte_id', $compteId)
                    ->orderBy('operations.created_at', 'DESC')
                    ->findAll();
    }

    public function situationGains(): array
    {
        return $this->db->query('SELECT * FROM v_gains_par_type')->getResultArray();
    }
}
