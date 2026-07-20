<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\CompteModel;
use App\Models\PrefixModel;

class AuthController extends BaseController
{
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

        $prefixModel = new PrefixModel();
        if (! $prefixModel->telephoneValide($telephone)) {
            return redirect()->to('/client/login')->with('error', 'Ce préfixe n\'est pas pris en charge par l\'opérateur.');
        }

        $compteModel = new CompteModel();
        $compte      = $compteModel->trouverOuCreer($telephone);

        session()->set([
            'compte_id' => $compte['id'],
            'telephone' => $telephone,
        ]);

        return redirect()->to('/client/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/client/login');
    }
}
