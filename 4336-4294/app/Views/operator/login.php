<?= $this->extend('layout/operator') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-3 text-center">Connexion Opérateur</h4>
                <form method="post" action="<?= site_url('operateur/login') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Identifiant</label>
                        <input type="text" name="login" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
