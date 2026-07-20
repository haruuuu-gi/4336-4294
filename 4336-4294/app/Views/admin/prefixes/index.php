<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<h5 class="mb-3">Configuration des préfixes externes</h5>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6>Ajouter un préfixe externe</h6>
                <form method="post" action="<?= site_url('admin/prefixes') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Préfixe externe (3 chiffres)</label>
                        <input type="text" name="prefixe" maxlength="3" class="form-control" placeholder="032" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Commission externe (%)</label>
                        <input type="number" step="0.1" min="0" name="commission_percent" class="form-control" value="1.0">
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <table class="table table-striped bg-white shadow-sm">
            <thead>
                <tr>
                    <th>Préfixe externe</th>
                    <th>Commission %</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($prefixes as $p): ?>
                <tr>
                    <td><?= esc($p['prefixe']) ?></td>
                    <td>
                        <form method="post" action="<?= site_url('admin/prefixes/' . $p['id'] . '/update') ?>" class="d-flex gap-2 align-items-center">
                            <?= csrf_field() ?>
                            <input type="number" step="0.1" min="0" name="commission_percent" class="form-control form-control-sm" style="width:100px" value="<?= esc($p['commission_percent'] ?? 1.0) ?>">
                            <button class="btn btn-sm btn-primary" type="submit">OK</button>
                        </form>
                    </td>
                    <td><?= $p['actif'] ? '<span class="badge bg-success">Actif</span>' : '<span class="badge bg-secondary">Inactif</span>' ?></td>
                    <td>
                        <a href="<?= site_url('admin/prefixes/' . $p['id'] . '/toggle') ?>" class="btn btn-sm btn-outline-secondary">Basculer</a>
                        <a href="<?= site_url('admin/prefixes/' . $p['id'] . '/delete') ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce préfixe ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
