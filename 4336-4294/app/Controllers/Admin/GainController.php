<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OperationModel;

class GainController extends BaseController
{
    public function index()
    {
        $operationModel = new OperationModel();
        $gains = $operationModel->situationGains();

        $totalGeneral = array_sum(array_column($gains, 'total_frais'));

        return view('admin/gains/index', [
            'gains' => $gains,
            'totalGeneral' => $totalGeneral,
        ]);
    }
}
