<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['nom', 'login', 'password', 'role', 'actif'];

    public function findByLogin(string $login): ?array
    {
        return $this->where('login', $login)->where('actif', 1)->first();
    }

    // public function verifierMotDePasse(string $login, string $password): ?array
    // {
    //     $user = $this->findByLogin($login);

    //     if ($user && password_verify($password, $user['password'])) {
    //         return $user;
    //     }

    //     return null;
    // }

    public function creerAdmin(string $nom, string $login, string $password, string $role = 'admin'): int
    {
        return (int) $this->insert([
            'nom' => $nom,
            'login' => $login,
            'password' => $password,
            'role' => $role,
            'actif' => 1,
        ], true);
    }
}
