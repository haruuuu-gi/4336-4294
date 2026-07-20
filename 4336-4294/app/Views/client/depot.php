<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <h5 class="section-title">📥 Faire un dépôt</h5>
        <div class="card shadow-sm">
            <div class="card-body">
                <p class="text-muted">Solde actuel : <strong class="text-mm-primary"><?= number_format($compte['solde'], 0, ',', ' ') ?> Ar</strong></p>
                <form method="post" action="<?= site_url('client/depot') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Montant à déposer (Ar)</label>
                        <input type="number" min="1" step="1" name="montant" class="form-control form-control-lg" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Valider le dépôt</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
