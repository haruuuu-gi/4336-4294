<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<h5 class="mb-3">Configuration des préfixes</h5>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6>Ajouter un préfixe</h6>
                <form method="post" action="<?= site_url('operateur/prefixes') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Préfixe (3 chiffres)</label>
                        <input type="text" name="prefixe" maxlength="3" class="form-control" placeholder="033" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <table class="table table-striped bg-white shadow-sm">
            <thead><tr><th>Préfixe</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($prefixes as $p): ?>
                <tr>
                    <td><?= esc($p['prefixe']) ?></td>
                    <td><?= $p['actif'] ? '<span class="badge bg-success">Actif</span>' : '<span class="badge bg-secondary">Inactif</span>' ?></td>
                    <td>
                        <a href="<?= site_url('operateur/prefixes/' . $p['id'] . '/toggle') ?>" class="btn btn-sm btn-outline-secondary">Basculer</a>
                        <a href="<?= site_url('operateur/prefixes/' . $p['id'] . '/delete') ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce préfixe ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
