<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\OperationModel;

class HistoriqueController extends BaseController
{
    public function index()
    {
        $operationModel = new OperationModel();
        $historique = $operationModel->historiquePourCompte((int) session()->get('compte_id'));

        return view('client/historique', ['historique' => $historique]);
    }
}
