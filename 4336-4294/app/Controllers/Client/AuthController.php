<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\CompteModel;

class AuthController extends BaseController
{
    protected string $ownPrefix = '039';

    public function login()
    {
        return view('client/login');
    }

    public function processLogin()
    {
        $telephone = trim($this->request->getPost('telephone'));

        if (empty($telephone) || ! preg_match('/^\d{9,10}$/', $telephone)) {
            return redirect()->to('/client/login')->with('error', 'Numéro de téléphone invalide.');
        }

        if (substr($telephone, 0, 3) !== $this->ownPrefix) {
            return redirect()->to('/client/login')->with('error', 'Ce site est réservé aux numéros de l\'opérateur 039.');
        }

        $compteModel = new CompteModel();
        $compte = $compteModel->trouverOuCreer($telephone);

        session()->set([
            'compte_id' => $compte['id'],
            'telephone' => $telephone,
        ]);

        return redirect()->to('/client/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
