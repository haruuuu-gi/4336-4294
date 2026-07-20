<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="login-wrapper justify-content-center">
    <div class="col-md-5 mx-auto">
        <div class="card login-card shadow">
            <div class="login-banner">
                <div class="login-icon">💳</div>
                <h4 class="mb-0 mt-2">Mobile Money</h4>
                <p class="mb-0 small opacity-75">Connexion client</p>
            </div>
            <div class="card-body p-4">
                <p class="text-muted text-center small">Entrez votre numéro de téléphone. Aucune inscription préalable n'est nécessaire.</p>
                <form method="post" action="<?= site_url('client/login') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Numéro de téléphone</label>
                        <input type="text" name="telephone" class="form-control form-control-lg" placeholder="0331234567" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-lg">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
