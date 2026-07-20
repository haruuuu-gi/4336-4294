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
        'compte_id', 'compte_dest_id', 'telephone_dest', 'operation_type_id',
        'montant', 'frais', 'commission', 'solde_apres',
    ];

    public function historiquePourCompte(int $compteId): array
    {
        return $this->select('operations.*, operation_types.libelle as operation_libelle, COALESCE(operations.telephone_dest, cl2.telephone) as telephone_dest')
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

    public function situationGainsSplit(string $ownPrefix): array
    {
        $sql = "SELECT
            ot.id AS operation_type_id,
            ot.libelle AS operation,
            CASE WHEN substr(cl2.telephone, 1, 3) = ? THEN 'operateur' ELSE 'autre_operateur' END AS categorie,
            COUNT(o.id) AS nb_operations,
            COALESCE(SUM(o.frais), 0) AS total_frais
        FROM operation_types ot
        LEFT JOIN operations o ON o.operation_type_id = ot.id
        LEFT JOIN comptes c2 ON c2.id = o.compte_dest_id
        LEFT JOIN clients cl2 ON cl2.id = c2.client_id
        GROUP BY ot.id, categorie
        ORDER BY ot.id, categorie";

        $query = $this->db->query($sql, [$ownPrefix]);
        return $query->getResultArray();
    }

    public function montantParOperateur(): array
    {
        $sql = "SELECT
            COALESCE(substr(COALESCE(o.telephone_dest, cl2.telephone), 1, 3), 'N/A') AS prefixe,
            COUNT(o.id) AS nb_operations,
            COALESCE(SUM(o.montant), 0) AS total_montant,
            COALESCE(SUM(o.frais), 0) AS total_frais
        FROM operations o
        LEFT JOIN comptes c2 ON c2.id = o.compte_dest_id
        LEFT JOIN clients cl2 ON cl2.id = c2.client_id
        WHERE o.operation_type_id = (SELECT id FROM operation_types WHERE code = 'transfert' LIMIT 1)
          AND o.compte_id IS NOT NULL
        GROUP BY prefixe
        ORDER BY total_montant DESC";

        return $this->db->query($sql)->getResultArray();
    }

    public function detailsTransferts(): array
    {
        $sql = "SELECT
            o.id,
            o.created_at,
            cl.telephone AS telephone_envoyeur,
            COALESCE(o.telephone_dest, cl2.telephone) AS telephone_destinataire,
            o.montant,
            o.frais AS frais_operateur,
            o.commission AS commission_externe,
            (o.montant + o.frais + o.commission) AS total_debite
        FROM operations o
        JOIN comptes c ON c.id = o.compte_id
        JOIN clients cl ON cl.id = c.client_id
        LEFT JOIN comptes c2 ON c2.id = o.compte_dest_id
        LEFT JOIN clients cl2 ON cl2.id = c2.client_id
        WHERE o.operation_type_id = (SELECT id FROM operation_types WHERE code = 'transfert' LIMIT 1)
          AND o.compte_id IS NOT NULL
        ORDER BY o.created_at DESC";

        return $this->db->query($sql)->getResultArray();
    }
}
