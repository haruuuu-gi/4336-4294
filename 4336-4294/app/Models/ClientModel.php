<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['telephone'];

    public function parTelephone(string $telephone)
    {
        return $this->where('telephone', $telephone)->first();
    }
}
