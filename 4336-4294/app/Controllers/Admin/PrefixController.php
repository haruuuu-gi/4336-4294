<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PrefixModel;

class PrefixController extends BaseController
{
    protected PrefixModel $model;

    public function __construct()
    {
        $this->model = new PrefixModel();
    }

    public function index()
    {
        return view('admin/prefixes/index', ['prefixes' => $this->model->findAll()]);
    }

    public function update($id)
    {
        $commission = (float) $this->request->getPost('commission_percent', 1.0);

        $this->model->update($id, ['commission_percent' => $commission]);

        return redirect()->to('/admin/prefixes')->with('success', 'Commission mise à jour.');
    }

    public function bulk()
    {
        if ($this->request->getMethod() === 'post') {
            $commissions = $this->request->getPost('commission') ?? [];
            foreach ($commissions as $id => $val) {
                $this->model->update((int)$id, ['commission_percent' => (float)$val]);
            }

            return redirect()->to('/admin/prefixes/bulk')->with('success', 'Commissions mises à jour.');
        }

        return view('admin/prefixes/bulk', ['prefixes' => $this->model->findAll()]);
    }

    public function create()
    {
        $prefixe = trim($this->request->getPost('prefixe'));
        $commission = (float) $this->request->getPost('commission_percent', 1.0);

        if (! preg_match('/^\d{3}$/', $prefixe)) {
            return redirect()->to('/admin/prefixes')->with('error', 'Le préfixe doit contenir exactement 3 chiffres.');
        }

        $this->model->insert(['prefixe' => $prefixe, 'actif' => 1, 'commission_percent' => $commission]);

        return redirect()->to('/admin/prefixes')->with('success', 'Préfixe ajouté.');
    }

    public function toggle($id)
    {
        $prefixe = $this->model->find($id);
        if ($prefixe) {
            $this->model->update($id, ['actif' => $prefixe['actif'] ? 0 : 1]);
        }

        return redirect()->to('/admin/prefixes')->with('success', 'Statut mis à jour.');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/admin/prefixes')->with('success', 'Préfixe supprimé.');
    }
}
