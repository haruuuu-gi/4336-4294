<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="login-wrapper justify-content-center">
    <div class="col-md-5 mx-auto">
        <div class="card login-card login-admin shadow">
            <div class="login-banner">
                <div class="login-icon">🛠️</div>
                <h4 class="mb-0 mt-2">Espace Admin</h4>
                <p class="mb-0 small opacity-75">Simulateur Mobile Money</p>
            </div>
            <div class="card-body p-4">
                <form method="post" action="<?= site_url('admin/login') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Identifiant</label>
                        <input type="text" name="login" class="form-control form-control-lg" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control form-control-lg" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100 btn-lg">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
