<?php
// Simple simulation script to test multi-send and external/internal transfers.
// Usage from project root: php tools/simulate_transfers.php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\CompteModel;
use App\Models\ClientModel;
use App\Models\PrefixModel;
use App\Libraries\OperationService;

$compteModel = new CompteModel();
$clientModel = new ClientModel();
$prefixModel = new PrefixModel();
$service = new OperationService();

function ensureClientAndCompte($telephone) {
    $cm = new ClientModel();
    $cp = new CompteModel();
    $client = $cm->parTelephone($telephone);
    if ($client === null) {
        $id = $cm->insert(['telephone' => $telephone], true);
    } else {
        $id = $client['id'];
    }
    $compte = $cp->parClientId($id);
    if ($compte === null) {
        $compteId = $cp->insert(['client_id' => $id, 'solde' => 0], true);
        $compte = $cp->find($compteId);
    }
    return $compte;
}

// Setup: ensure two local accounts
$senderTel = '0332000001';
$localDest1 = '0333000001';
$localDest2 = '0333000002';
$externalDest = '0324000001';

$sender = ensureClientAndCompte($senderTel);
$local1 = ensureClientAndCompte($localDest1);
$local2 = ensureClientAndCompte($localDest2);

// Credit sender for testing
$compteModel->crediter($sender['id'], 100000); // 1000.00 if units are Ar
$sender = $compteModel->find($sender['id']);

echo "Before transfers:\n";
echo "Sender ({$senderTel}) solde: " . number_format($sender['solde'], 2) . "\n";

echo "--- Multi-send to two locals (10000) ---\n";
$service->transfert($sender['id'], $localDest1, 5000, false);
$service->transfert($sender['id'], $localDest2, 5000, false);

$sender = $compteModel->find($sender['id']);
$dest1 = $compteModel->parTelephone($localDest1);
$dest2 = $compteModel->parTelephone($localDest2);

echo "After local sends:\n";
echo "Sender solde: " . number_format($sender['solde'], 2) . "\n";
echo "Dest1 solde: " . number_format($dest1['solde'], 2) . "\n";
echo "Dest2 solde: " . number_format($dest2['solde'], 2) . "\n";

echo "--- Send to external (032) 10000 ---\n";
try {
    $service->transfert($sender['id'], $externalDest, 10000, false);
    $sender = $compteModel->find($sender['id']);
    echo "After external send, sender solde: " . number_format($sender['solde'], 2) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "Simulation complete.\n";
