<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="login-page">
    <div class="login-container">
        <div class="text-center mb-4">
            <div class="login-logo">🛠️</div>
            <h4 class="login-title">Espace Admin</h4>
            <p class="login-subtitle">Simulateur Mobile Money</p>
        </div>
        <form class="login-form" method="post" action="<?= site_url('admin/login') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Identifiant</label>
                <input type="text" name="login" class="form-control form-control-lg" required>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control form-control-lg" required>
            </div>
            <button type="submit" class="btn btn-dark w-100 login-btn">Se connecter</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
