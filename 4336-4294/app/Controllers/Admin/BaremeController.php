<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BaremeModel;
use App\Models\OperationTypeModel;

class BaremeController extends BaseController
{
    protected BaremeModel $model;
    protected OperationTypeModel $typeModel;

    public function __construct()
    {
        $this->model = new BaremeModel();
        $this->typeModel = new OperationTypeModel();
    }

    public function index($operationTypeId)
    {
        $type = $this->typeModel->find($operationTypeId);
        $baremes = $this->model->pourType((int) $operationTypeId);

        return view('admin/baremes/index', [
            'type' => $type,
            'baremes' => $baremes,
        ]);
    }

    public function create($operationTypeId)
    {
        $montantMin = (float) $this->request->getPost('montant_min');
        $montantMax = (float) $this->request->getPost('montant_max');
        $frais = (float) $this->request->getPost('frais');

        if ($montantMax  = $montantMin) {
            return redirect()->to('/admin/types-operation/' . $operationTypeId . '/baremes')
                ->with('error', 'Le montant max doit être supérieur au montant min.');
        }

        $this->model->insert([
            'operation_type_id' => $operationTypeId,
            'montant_min' => $montantMin,
            'montant_max' => $montantMax,
            'frais' => $frais,
        ]);

        return redirect()->to('/admin/types-operation/' . $operationTypeId . '/baremes')
            ->with('success', 'Tranche ajoutée.');
    }

    public function delete($id)
    {
        $bareme = $this->model->find($id);
        if ($bareme) {
            $this->model->delete($id);
        }

        return redirect()->to('/admin/types-operation/' . ($bareme['operation_type_id'] ?? '') . '/baremes')
            ->with('success', 'Tranche supprimée.');
    }
}
