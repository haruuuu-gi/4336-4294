<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\CompteModel;

class EpargneController extends BaseController
{
    public function index()
    {
        $compteModel = new CompteModel();
        $compte = $compteModel->find(session()->get('compte_id'));
        $compte['telephone'] = session()->get('telephone');

        return view('client/epargne', ['compte' => $compte]);
        
    }
}
