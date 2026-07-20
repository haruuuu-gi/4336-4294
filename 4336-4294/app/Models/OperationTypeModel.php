<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationTypeModel extends Model
{
    protected $table = 'operation_types';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['code', 'libelle', 'actif'];

    public function findByCode(string $code)
    {
        return $this->where('code', $code)->first();
    }
}
