<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="page-panel">
    <div class="page-header">
        <h5 class="section-title">📤 Faire un retrait</h5>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <p class="text-muted">Solde actuel : <strong class="fw-bold text-dark"><?= number_format($compte['solde'], 0, ',', ' ') ?> Ar</strong></p>
                <form method="post" action="<?= site_url('client/retrait') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Montant à retirer (Ar)</label>
                        <input type="number" min="1" step="1" name="montant" class="form-control form-control-lg" required>
                        <div class="form-text">Des frais seront prélevés.</div>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">Valider le retrait</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
