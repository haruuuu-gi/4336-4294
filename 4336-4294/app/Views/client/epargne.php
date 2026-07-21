<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="page-panel">
    <div class="page-header">
        <h5 class="section-title">Espace client</h5>
    </div>

    <div class="widget p-4 mb-4 text-center">
        <p class="text-muted mb-2">Solde de <?= esc($compte['telephone']) ?></p>
        <div class="h1 fw-bold text-dark"><?= number_format($compte['solde'], 0, ',', ' ') ?> Ar</div>
    </div>

        <div class="widget p-4 mb-4 text-center">
        <p class="text-muted mb-2">Epargne de <?= esc($compte['telephone']) ?></p>
        <div class="h1 fw-bold text-dark"><?= number_format($compte['epargne'], 0, ',', ' ') ?> Ar</div>
    </div>
</div>
