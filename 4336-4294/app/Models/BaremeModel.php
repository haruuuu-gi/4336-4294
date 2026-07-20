<?php

namespace App\Models;

use CodeIgniter\Model;

class BaremeModel extends Model
{
    protected $table = 'baremes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['operation_type_id', 'montant_min', 'montant_max', 'frais'];

    public function pourType(int $operationTypeId)
    {
        return $this->where('operation_type_id', $operationTypeId)
                    ->orderBy('montant_min', 'ASC')
                    ->findAll();
    }

    public function fraisPour(int $operationTypeId, float $montant)
    {
        $tranche = $this->where('operation_type_id', $operationTypeId)
                        ->where('montant_min <=', $montant)
                        ->where('montant_max >=', $montant)
                        ->first();

        return $tranche ? $tranche['frais'] : 0.0;
    }
}
