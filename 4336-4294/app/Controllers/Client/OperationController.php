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
        $telephoneDestRaw = trim($this->request->getPost('telephone_dest'));
        $montant          = (float) $this->request->getPost('montant');
        $inclureFrais     = (bool) $this->request->getPost('inclure_frais');

        // parse multiple numbers (comma or newline separated)
        $parts = preg_split('/[\n,;]+/', $telephoneDestRaw);
        $destinations = array_filter(array_map('trim', $parts));

        try {
            $service = new OperationService();

            if (count($destinations) <= 1) {
                $service->transfert($this->compteId(), $destinations[0] ?? '', $montant, $inclureFrais);
            } else {
                // ensure all recipients share the same operator prefix
                $prefixes = array_map(fn($t) => substr($t, 0, 3), $destinations);
                $unique = array_unique($prefixes);
                if (count($unique) !== 1) {
                    throw new RuntimeException('Tous les destinataires doivent appartenir au même opérateur pour un envoi multiple.');
                }

                // split amount evenly with cent precision and distribute remainder to the first recipients
                $count = count($destinations);
                $cents = (int) round($montant * 100);
                $shareCents = intdiv($cents, $count);
                $remainder = $cents - ($shareCents * $count);

                // Distribute remainder to the last recipients (fairer UX for senders)
                foreach (array_values($destinations) as $i => $dest) {
                    $extra = ($i >= ($count - $remainder)) ? 1 : 0;
                    $amountCents = $shareCents + $extra;
                    $amount = $amountCents / 100.0;
                    $service->transfert($this->compteId(), $dest, $amount, $inclureFrais);
                }
            }

            return redirect()->to('/client/dashboard')->with('success', 'Transfert effectué avec succès.');
        } catch (RuntimeException $e) {
            return redirect()->to('/client/transfert')->with('error', $e->getMessage());
        }
    }
}
