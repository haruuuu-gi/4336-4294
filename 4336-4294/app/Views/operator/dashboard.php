<?= $this->extend('layout/operator') ?>
<?= $this->section('content') ?>

<h4 class="mb-4">Tableau de bord opérateur</h4>

<div class="row g-3">
    <div class="col-md-3">
        <a href="<?= site_url('operateur/prefixes') ?>" class="text-decoration-none">
            <div class="card shadow-sm text-center p-4">
                <h6>Préfixes</h6>
                <p class="text-muted mb-0">Configurer les préfixes valables</p>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?= site_url('operateur/types-operation') ?>" class="text-decoration-none">
            <div class="card shadow-sm text-center p-4">
                <h6>Types & Barèmes</h6>
                <p class="text-muted mb-0">Gérer les frais par tranche</p>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?= site_url('operateur/gains') ?>" class="text-decoration-none">
            <div class="card shadow-sm text-center p-4">
                <h6>Gains</h6>
                <p class="text-muted mb-0">Situation des frais perçus</p>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?= site_url('operateur/comptes') ?>" class="text-decoration-none">
            <div class="card shadow-sm text-center p-4">
                <h6>Comptes clients</h6>
                <p class="text-muted mb-0">Situation des comptes</p>
            </div>
        </a>
    </div>
</div>

<?= $this->endSection() ?>
