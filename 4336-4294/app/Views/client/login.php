<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="login-page">
    <div class="login-container">
        <div class="text-center mb-4">
            <div class="login-logo">💳</div>
            <h4 class="login-title">Golden Money</h4>
            <p class="login-subtitle">Connexion client</p>
        </div>
        <p class="text-muted text-center small mb-4">Entrez votre numéro.</p>
        <form class="login-form" method="post" action="<?= site_url('client/login') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label>Numéro de téléphone</label>
                <input type="text" name="telephone" class="form-control form-control-lg" placeholder="0391234567" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 login-btn">Se connecter</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
