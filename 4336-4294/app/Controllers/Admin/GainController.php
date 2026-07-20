<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OperationModel;

class GainController extends BaseController
{
    public function index()
    {
        $operationModel = new OperationModel();
        $ownPrefix = '039';
        $gains = $operationModel->situationGainsSplit($ownPrefix);

        $totalGeneral = array_sum(array_column($gains, 'total_frais'));

        $montantsParOperateur = $operationModel->montantParOperateur();
        $transfertsDetails = $operationModel->detailsTransferts();

        return view('admin/gains/index', [
            'gains' => $gains,
            'totalGeneral' => $totalGeneral,
            'ownPrefix' => $ownPrefix,
            'montantsParOperateur' => $montantsParOperateur,
            'transfertsDetails' => $transfertsDetails,
        ]);
    }
}
