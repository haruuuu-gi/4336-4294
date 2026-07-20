<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-solde shadow p-4 text-center mb-4">
            <div class="solde-label">Solde de <?= esc($compte['telephone']) ?></div>
            <div class="solde-montant"><?= number_format($compte['solde'], 0, ',', ' ') ?> Ar</div>
        </div>

        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a href="<?= site_url('client/depot') ?>" class="menu-tile">
                    <span class="menu-icon">📥</span>
                    <h6>Dépôt</h6>
                    <p>Créditer mon compte</p>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="<?= site_url('client/retrait') ?>" class="menu-tile">
                    <span class="menu-icon">📤</span>
                    <h6>Retrait</h6>
                    <p>Retirer des espèces</p>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="<?= site_url('client/transfert') ?>" class="menu-tile">
                    <span class="menu-icon">🔁</span>
                    <h6>Transfert</h6>
                    <p>Envoyer de l'argent</p>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="<?= site_url('client/historique') ?>" class="menu-tile">
                    <span class="menu-icon">📜</span>
                    <h6>Historique</h6>
                    <p>Mes opérations</p>
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
