<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixModel extends Model
{
    protected $table = 'prefixes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['prefixe', 'actif'];

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
}
