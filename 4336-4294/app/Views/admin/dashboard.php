<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<h4 class="section-title admin">Tableau de bord administrateur</h4>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="tile-stat tile-1">
            <h6>Comptes clients</h6>
            <div class="tile-value"><?= (int) $nbComptes ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="tile-stat tile-2">
            <h6>Solde total en circulation</h6>
            <div class="tile-value"><?= number_format($totalSolde, 0, ',', ' ') ?> Ar</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="tile-stat tile-3">
            <h6>Opérations effectuées</h6>
            <div class="tile-value"><?= (int) $nbOperations ?></div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="tile-stat tile-4">
            <h6>Frais perçus (total)</h6>
            <div class="tile-value"><?= number_format($totalFrais, 0, ',', ' ') ?> Ar</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-3">
        <a href="<?= site_url('admin/prefixes') ?>" class="menu-tile">
            <span class="menu-icon">📶</span>
            <h6>Préfixes</h6>
            <p>Configurer les préfixes valables</p>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?= site_url('admin/types-operation') ?>" class="menu-tile">
            <span class="menu-icon">💱</span>
            <h6>Types & Barèmes</h6>
            <p>Gérer les frais par tranche</p>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?= site_url('admin/gains') ?>" class="menu-tile">
            <span class="menu-icon">📈</span>
            <h6>Gains</h6>
            <p>Situation des frais perçus</p>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?= site_url('admin/comptes') ?>" class="menu-tile">
            <span class="menu-icon">👥</span>
            <h6>Comptes clients</h6>
            <p>Situation des comptes</p>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?= site_url('admin/utilisateurs') ?>" class="menu-tile">
            <span class="menu-icon">🔐</span>
            <h6>Administrateurs</h6>
            <p>Gérer les comptes admin</p>
        </a>
    </div>
</div>

<?= $this->endSection() ?>
