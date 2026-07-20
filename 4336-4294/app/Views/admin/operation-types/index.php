<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<h5 class="section-title admin">💱 Types d'opérations</h5>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6>Ajouter un type d'opération</h6>
                <form method="post" action="<?= site_url('admin/types-operation') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Code (ex: depot)</label>
                        <input type="text" name="code" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Libellé (ex: Dépôt)</label>
                        <input type="text" name="libelle" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <table class="table table-admin table-striped bg-white shadow-sm">
            <thead><tr><th>Code</th><th>Libellé</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($types as $t): ?>
                <tr>
                    <td><?= esc($t['code']) ?></td>
                    <td><?= esc($t['libelle']) ?></td>
                    <td><?= $t['actif'] ? '<span class="badge badge-actif">Actif</span>' : '<span class="badge badge-inactif">Inactif</span>' ?></td>
                    <td>
                        <a href="<?= site_url('admin/types-operation/' . $t['id'] . '/baremes') ?>" class="btn btn-sm btn-outline-primary">Barème de frais</a>
                        <a href="<?= site_url('admin/types-operation/' . $t['id'] . '/toggle') ?>" class="btn btn-sm btn-outline-secondary">Basculer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
