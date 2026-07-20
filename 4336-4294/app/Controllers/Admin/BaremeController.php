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

        if ($montantMax <= $montantMin) {
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

    public function edit($id)
    {
        $bareme = $this->model->find($id);
        if (! $bareme) {
            return redirect()->to('/admin/types-operation')->with('error', 'Tranche introuvable.');
        }

        $type = $this->typeModel->find($bareme['operation_type_id']);

        return view('admin/baremes/edit', [
            'type' => $type,
            'bareme' => $bareme,
        ]);
    }

    public function update($id)
    {
        $bareme = $this->model->find($id);
        if (! $bareme) {
            return redirect()->to('/admin/types-operation')->with('error', 'Tranche introuvable.');
        }

        $montantMin = (float) $this->request->getPost('montant_min');
        $montantMax = (float) $this->request->getPost('montant_max');
        $frais = (float) $this->request->getPost('frais');

        if ($montantMax <= $montantMin) {
            return redirect()->to('/admin/baremes/' . $id . '/edit')
                ->with('error', 'Le montant max doit être supérieur au montant min.');
        }

        $this->model->update($id, [
            'montant_min' => $montantMin,
            'montant_max' => $montantMax,
            'frais' => $frais,
        ]);

        return redirect()->to('/admin/types-operation/' . $bareme['operation_type_id'] . '/baremes')
            ->with('success', 'Tranche mise à jour.');
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
