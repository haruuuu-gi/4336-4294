<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<h5 class="section-title admin">💱 Barème de frais — <?= esc($type['libelle'] ?? '') ?></h5>
<a href="<?= site_url('admin/types-operation') ?>" class="btn btn-sm btn-outline-secondary mb-3">&larr; Retour aux types</a>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6>Ajouter une tranche</h6>
                <form method="post" action="<?= site_url('admin/types-operation/' . $type['id'] . '/baremes') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-2">
                        <label class="form-label">Montant min (Ar)</label>
                        <input type="number" step="1" name="montant_min" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Montant max (Ar)</label>
                        <input type="number" step="1" name="montant_max" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Frais (Ar)</label>
                        <input type="number" step="1" name="frais" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <table class="table table-admin table-striped bg-white shadow-sm">
            <thead><tr><th>Montant compris entre</th><th>Frais</th><th>Actions</th></tr></thead>
            <tbody>
            <?php if (empty($baremes)): ?>
                <tr><td colspan="3" class="text-center text-muted">Aucune tranche définie (opération gratuite).</td></tr>
            <?php endif; ?>
            <?php foreach ($baremes as $b): ?>
                <tr>
                    <td><?= number_format($b['montant_min'], 0, ',', ' ') ?> et <?= number_format($b['montant_max'], 0, ',', ' ') ?> Ar</td>
                    <td><?= number_format($b['frais'], 0, ',', ' ') ?> Ar</td>
                    <td>
                        <a href="<?= site_url('admin/baremes/' . $b['id'] . '/edit') ?>" class="btn btn-sm btn-outline-primary me-2">Modifier</a>
                    <a href="<?= site_url('admin/baremes/' . $b['id'] . '/delete') ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cette tranche ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
