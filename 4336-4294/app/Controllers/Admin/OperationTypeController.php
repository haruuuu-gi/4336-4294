<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OperationTypeModel;

class OperationTypeController extends BaseController
{
    protected OperationTypeModel $model;

    public function __construct()
    {
        $this->model = new OperationTypeModel();
    }

    public function index()
    {
        return view('admin/operation_types/index', ['types' => $this->model->findAll()]);
    }

    public function create()
    {
        $code = trim($this->request->getPost('code'));
        $libelle = trim($this->request->getPost('libelle'));

        if (empty($code) || empty($libelle)) {
            return redirect()->to('/admin/types-operation')->with('error', 'Code et libellé requis.');
        }

        $this->model->insert(['code' => $code, 'libelle' => $libelle, 'actif' => 1]);

        return redirect()->to('/admin/types-operation')->with('success', "Type d'opération ajouté.");
    }

    public function toggle($id)
    {
        $type = $this->model->find($id);
        if ($type) {
            $this->model->update($id, ['actif' => $type['actif'] ? 0 : 1]);
        }

        return redirect()->to('/admin/types-operation')->with('success', 'Statut mis à jour.');
    }
}
