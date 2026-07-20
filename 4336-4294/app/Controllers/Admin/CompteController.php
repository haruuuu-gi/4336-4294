<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class CompteController extends BaseController
{
    public function index()
    {
        $db = db_connect();
        $comptes = $db->query('SELECT * FROM v_comptes_clients ORDER BY created_at DESC')->getResultArray();

        $totalSolde = array_sum(array_column($comptes, 'solde'));

        return view('admin/comptes/index', [
            'comptes' => $comptes,
            'totalSolde' => $totalSolde,
        ]);
    }
}
