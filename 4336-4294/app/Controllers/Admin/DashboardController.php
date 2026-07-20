<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = db_connect();

        $nbComptes = $db->query('SELECT COUNT(*) as n FROM comptes')->getRow()->n;
        $totalSolde = $db->query('SELECT COALESCE(SUM(solde),0) as s FROM comptes')->getRow()->s;
        $nbOperations = $db->query('SELECT COUNT(*) as n FROM operations')->getRow()->n;
        $totalFrais = $db->query('SELECT COALESCE(SUM(frais),0) as s FROM operations')->getRow()->s;

        return view('admin/dashboard', [
            'nbComptes' => $nbComptes,
            'totalSolde' => $totalSolde,
            'nbOperations' => $nbOperations,
            'totalFrais' => $totalFrais,
        ]);
    }
}
