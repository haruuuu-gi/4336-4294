<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixModel extends Model
{
    protected $table = 'prefixes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['prefixe', 'actif', 'commission_percent'];
    public const OWN_PREFIX = '039';

    public function externes()
    {
        return $this->where('prefixe !=', self::OWN_PREFIX)->findAll();
    }

    public function telephoneValide(string $telephone)
    {
        $prefixe = substr($telephone, 0, 3);

        return $this->where('prefixe', $prefixe)
                     ->where('actif', 1)
                     ->countAllResults() > 0;
    }

    public function actifs()
    {
        return $this->where('actif', 1)->findAll();
    }

    public function commissionPourPrefixe(string $prefixe)
    {
        $row = $this->where('prefixe', $prefixe)->first();
        if (! $row) {
            return 1.0;
        }

        return isset($row['commission_percent']) ? $row['commission_percent'] : 1.0;
    }
}
