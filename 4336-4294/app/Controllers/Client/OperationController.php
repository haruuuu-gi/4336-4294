<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Libraries\OperationService;
use App\Models\CompteModel;
use RuntimeException;

class OperationController extends BaseController
{
    protected function compteId(): int
    {
        return (int) session()->get('compte_id');
    }

    protected function compteAvecTelephone(): array
    {
        $compteModel = new CompteModel();
        $compte = $compteModel->find($this->compteId());
        $compte['telephone'] = session()->get('telephone');
        return $compte;
    }

    public function depot()
    {
        return view('client/depot', ['compte' => $this->compteAvecTelephone()]);
    }

    public function processDepot()
    {
        $montant = (float) $this->request->getPost('montant');

        try {
            $service = new OperationService();
            $service->depot($this->compteId(), $montant);

            return redirect()->to('/client/dashboard')->with('success', 'Dépôt effectué avec succès.');
        } catch (RuntimeException $e) {
            return redirect()->to('/client/depot')->with('error', $e->getMessage());
        }
    }

    public function retrait()
    {
        return view('client/retrait', ['compte' => $this->compteAvecTelephone()]);
    }

    public function processRetrait()
    {
        $montant = (float) $this->request->getPost('montant');

        try {
            $service = new OperationService();
            $service->retrait($this->compteId(), $montant);

            return redirect()->to('/client/dashboard')->with('success', 'Retrait effectué avec succès.');
        } catch (RuntimeException $e) {
            return redirect()->to('/client/retrait')->with('error', $e->getMessage());
        }
    }

    public function transfert()
    {
        return view('client/transfert', ['compte' => $this->compteAvecTelephone()]);
    }

    public function processTransfert()
    {
        $telephoneDest = trim($this->request->getPost('telephone_dest'));
        $montant       = (float) $this->request->getPost('montant');

        try {
            $service = new OperationService();
            $service->transfert($this->compteId(), $telephoneDest, $montant);

            return redirect()->to('/client/dashboard')->with('success', 'Transfert effectué avec succès.');
        } catch (RuntimeException $e) {
            return redirect()->to('/client/transfert')->with('error', $e->getMessage());
        }
    }
}
