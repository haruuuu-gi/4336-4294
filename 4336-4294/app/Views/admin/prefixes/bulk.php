<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<h5 class="mb-3">Édition en masse des commissions par préfixe</h5>

<form method="post" action="<?= site_url('admin/prefixes/bulk') ?>">
    <?= csrf_field() ?>
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <table class="table table-striped">
                <thead><tr><th>Préfixe</th><th>Commission (%)</th><th>Actif</th></tr></thead>
                <tbody>
                <?php foreach ($prefixes as $p): ?>
                    <tr>
                        <td><?= esc($p['prefixe']) ?></td>
                        <td><input type="number" step="0.1" min="0" name="commission[<?= (int)$p['id'] ?>]" value="<?= esc($p['commission_percent'] ?? 1.0) ?>" class="form-control" style="width:120px"></td>
                        <td><?= $p['actif'] ? 'Oui' : 'Non' ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary">Enregistrer les modifications</button>
            </div>
        </div>
    </div>
</form>

<?= $this->endSection() ?>
