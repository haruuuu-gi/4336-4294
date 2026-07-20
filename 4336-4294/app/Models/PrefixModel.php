<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixModel extends Model
{
    protected $table = 'prefixes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    // Allowed fields include commission percent
    protected $allowedFields = ['prefixe', 'actif', 'commission_percent'];

    /**
     * Vérifie si un numéro de téléphone correspond à un préfixe actif.
     */
    public function telephoneValide(string $telephone): bool
    {
        $prefixe = substr($telephone, 0, 3);

        return $this->where('prefixe', $prefixe)
                     ->where('actif', 1)
                     ->countAllResults() > 0;
    }

    public function actifs(): array
    {
        return $this->where('actif', 1)->findAll();
    }

    public function commissionPourPrefixe(string $prefixe): float
    {
        $row = $this->where('prefixe', $prefixe)->first();
        if (! $row) {
            return 1.0;
        }

        return isset($row['commission_percent']) ? (float) $row['commission_percent'] : 1.0;
    }
}
