<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="page-title">Tableau de bord administrateur</div>

<div class="grid mb-4">
    <div class="stat-card p-4">
        <div class="stat-title">Comptes clients</div>
        <div class="stat-number"><?= (int) $nbComptes ?></div>
    </div>
    <div class="stat-card p-4">
        <div class="stat-title">Solde total en circulation</div>
        <div class="stat-number"><?= number_format($totalSolde, 0, ',', ' ') ?> Ar</div>
    </div>
    <div class="stat-card p-4">
        <div class="stat-title">Opérations effectuées</div>
        <div class="stat-number"><?= (int) $nbOperations ?></div>
    </div>
    <div class="stat-card p-4">
        <div class="stat-title">Frais perçus (total)</div>
        <div class="stat-number"><?= number_format($totalFrais, 0, ',', ' ') ?> Ar</div>
    </div>
</div>

<div class="grid">
    <a href="<?= site_url('admin/prefixes') ?>" class="card text-center text-decoration-none h-100 p-4">
        <span class="stat-icon">📶</span>
        <h6>Préfixes</h6>
        <p class="text-muted mb-0">Configurer les préfixes valables</p>
    </a>
    <a href="<?= site_url('admin/types-operation') ?>" class="card text-center text-decoration-none h-100 p-4">
        <span class="stat-icon">💱</span>
        <h6>Types & Barèmes</h6>
        <p class="text-muted mb-0">Gérer les frais par tranche</p>
    </a>
    <a href="<?= site_url('admin/gains') ?>" class="card text-center text-decoration-none h-100 p-4">
        <span class="stat-icon">📈</span>
        <h6>Gains</h6>
        <p class="text-muted mb-0">Situation des frais perçus</p>
    </a>
    <a href="<?= site_url('admin/comptes') ?>" class="card text-center text-decoration-none h-100 p-4">
        <span class="stat-icon">👥</span>
        <h6>Comptes clients</h6>
        <p class="text-muted mb-0">Situation des comptes</p>
    </a>
    <a href="<?= site_url('admin/utilisateurs') ?>" class="card text-center text-decoration-none h-100 p-4">
        <span class="stat-icon">🔐</span>
        <h6>Administrateurs</h6>
        <p class="text-muted mb-0">Gérer les comptes admin</p>
    </a>
</div>

<?= $this->endSection() ?>
