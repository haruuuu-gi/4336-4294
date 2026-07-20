<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
 
<div class="page-panel">
    <div class="page-header">
        <h5 class="section-title">Espace client</h5>
    </div>

    <div class="widget p-4 mb-4 text-center">
        <p class="text-muted mb-2">Solde de <?= esc($compte['telephone']) ?></p>
        <div class="h1 fw-bold text-dark"><?= number_format($compte['solde'], 0, ',', ' ') ?> Ar</div>
    </div>

    <div class="grid">
    <a href="<?= site_url('client/depot') ?>" class="card text-center text-decoration-none h-100 p-4">
        <span class="stat-icon">📥</span>
        <h6>Dépôt</h6>
        <p class="text-muted mb-0">Créditer mon compte</p>
    </a>
    <a href="<?= site_url('client/retrait') ?>" class="card text-center text-decoration-none h-100 p-4">
        <span class="stat-icon">📤</span>
        <h6>Retrait</h6>
        <p class="text-muted mb-0">Retirer des espèces</p>
    </a>
    <a href="<?= site_url('client/transfert') ?>" class="card text-center text-decoration-none h-100 p-4">
        <span class="stat-icon">🔁</span>
        <h6>Transfert</h6>
        <p class="text-muted mb-0">Envoyer de l'argent</p>
    </a>
    <a href="<?= site_url('client/historique') ?>" class="card text-center text-decoration-none h-100 p-4">
        <span class="stat-icon">📜</span>
        <h6>Historique</h6>
        <p class="text-muted mb-0">Mes opérations</p>
    </a>
</div>

</div>

<?= $this->endSection() ?>
