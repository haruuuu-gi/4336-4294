<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<h5 class="section-title admin">🔐 Comptes administrateurs</h5>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6>Ajouter un administrateur</h6>
                <form method="post" action="<?= site_url('admin/utilisateurs') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-2">
                        <label class="form-label">Nom complet</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Login</label>
                        <input type="text" name="login" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" minlength="6" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Créer</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <table class="table table-admin table-striped bg-white shadow-sm">
            <thead><tr><th>Nom</th><th>Login</th><th>Rôle</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= esc($u['nom']) ?></td>
                    <td><?= esc($u['login']) ?></td>
                    <td><?= esc($u['role']) ?></td>
                    <td><?= $u['actif'] ? '<span class="badge badge-actif">Actif</span>' : '<span class="badge badge-inactif">Inactif</span>' ?></td>
                    <td>
                        <a href="<?= site_url('admin/utilisateurs/' . $u['id'] . '/toggle') ?>" class="btn btn-sm btn-outline-secondary">Basculer</a>
                        <a href="<?= site_url('admin/utilisateurs/' . $u['id'] . '/delete') ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cet administrateur ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
