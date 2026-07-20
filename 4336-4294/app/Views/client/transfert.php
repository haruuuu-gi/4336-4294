<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="page-panel">
    <div class="page-header">
        <h5 class="section-title">🔁 Faire un transfert</h5>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <p class="text-muted">Solde actuel : <strong class="fw-bold text-dark"><?= number_format($compte['solde'], 0, ',', ' ') ?> Ar</strong></p>
                <form method="post" action="<?= site_url('client/transfert') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Numéro du destinataire</label>
                        <textarea name="telephone_dest" class="form-control form-control-lg" placeholder="ex: 03xxxxxxxx" rows="2" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Montant à transférer (Ar)</label>
                        <input type="number" min="1" step="1" name="montant" class="form-control form-control-lg" required>
                        <div class="form-text">Des frais seront prélevés.</div>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="inclure_frais" id="inclure_frais" class="form-check-input">
                        <label for="inclure_frais" class="form-check-label">Inclure les frais de retrait envoyés au destinataire</label>
                    </div>
                    <div class="mb-2 text-muted small">Pour envoyer à plusieurs destinataires, mettez les numéros séparés par une virgule ou une nouvelle ligne</div>
                    <button type="submit" class="btn btn-primary w-100">Valider le transfert</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
