<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\CompteModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $compteModel = new CompteModel();
        $compte = $compteModel->find(session()->get('compte_id'));
        $compte['telephone'] = session()->get('telephone');

        return view('client/dashboard', ['compte' => $compte]);
    }
}
