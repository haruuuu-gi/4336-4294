<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PrefixModel;

class PrefixController extends BaseController
{
    protected const OWN_PREFIX = PrefixModel::OWN_PREFIX;
    protected PrefixModel $model;

    public function __construct()
    {
        $this->model = new PrefixModel();
    }

    public function index()
    {
        return view('admin/prefixes/index', ['prefixes' => $this->model->externes()]);
    }

    protected function normalizeCommissionInput($value): float
    {
        $raw = str_replace(',', '.', trim((string) $value));

        if ($raw === '') {
            return 0.0;
        }

        if (! is_numeric($raw)) {
            return -1.0;
        }

        return (float) $raw;
    }

    public function update($id)
    {
        $commissionInput = $this->request->getPost('commission_percent');
        $commission = $this->normalizeCommissionInput($commissionInput ?? '1.0');
        $prefixe = $this->model->find($id);

        if (! $prefixe) {
            return redirect()->to('/admin/prefixes')->with('error', 'Préfixe introuvable.');
        }

        if ($prefixe['prefixe'] === self::OWN_PREFIX) {
            return redirect()->to('/admin/prefixes')->with('error', 'Modification du préfixe interne non autorisée.');
        }

        if ($commission < 0 || $commission > 100) {
            return redirect()->to('/admin/prefixes')->with('error', 'Le pourcentage doit être compris entre 0 et 100.');
        }

        $this->model->update($id, ['commission_percent' => $commission]);

        return redirect()->to('/admin/prefixes')->with('success', 'Commission mise à jour.');
    }

    public function bulk()
    {
        if ($this->request->getMethod() === 'post') {
            $commissions = $this->request->getPost('commission') ?? [];
            foreach ($commissions as $id => $val) {
                $prefixe = $this->model->find((int)$id);
                if (! $prefixe || $prefixe['prefixe'] === self::OWN_PREFIX) {
                    continue;
                }

                $commission = (float)$val;
                if ($commission < 0 || $commission > 100) {
                    continue;
                }

                $this->model->update((int)$id, ['commission_percent' => $commission]);
            }

            return redirect()->to('/admin/prefixes/bulk')->with('success', 'Commissions mises à jour.');
        }

        return view('admin/prefixes/bulk', ['prefixes' => $this->model->externes()]);
    }

    public function create()
    {
        $prefixe = trim($this->request->getPost('prefixe'));
        $commissionInput = $this->request->getPost('commission_percent');
        $commission = $this->normalizeCommissionInput($commissionInput ?? '1.0');

        if (! preg_match('/^\d{3}$/', $prefixe)) {
            return redirect()->to('/admin/prefixes')->with('error', 'Le préfixe doit contenir exactement 3 chiffres.');
        }

        if ($prefixe === self::OWN_PREFIX) {
            return redirect()->to('/admin/prefixes')->with('error', 'Le préfixe 039 est réservé, il ne doit pas être ajouté ici.');
        }

        if ($this->model->where('prefixe', $prefixe)->first()) {
            return redirect()->to('/admin/prefixes')->with('error', 'Ce préfixe existe déjà.');
        }

        if ($commission < 0 || $commission > 100) {
            return redirect()->to('/admin/prefixes')->with('error', 'Le pourcentage doit être compris entre 0 et 100.');
        }

        $this->model->insert(['prefixe' => $prefixe, 'actif' => 1, 'commission_percent' => $commission]);

        return redirect()->to('/admin/prefixes')->with('success', 'Préfixe ajouté.');
    }

    public function toggle($id)
    {
        $prefixe = $this->model->find($id);
        if ($prefixe && $prefixe['prefixe'] !== self::OWN_PREFIX) {
            $this->model->update($id, ['actif' => $prefixe['actif'] ? 0 : 1]);
        }

        return redirect()->to('/admin/prefixes')->with('success', 'Statut mis à jour.');
    }

    public function delete($id)
    {
        $prefixe = $this->model->find($id);
        if ($prefixe && $prefixe['prefixe'] !== self::OWN_PREFIX) {
            $this->model->delete($id);
        }

        return redirect()->to('/admin/prefixes')->with('success', 'Préfixe supprimé.');
    }
}
