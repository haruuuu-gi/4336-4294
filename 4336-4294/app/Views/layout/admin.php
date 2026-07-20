<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Espace Admin' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/style.css') ?>" rel="stylesheet">
</head>
<body class="bg-light">
<?php if (session()->get('admin_id')): ?>
<nav class="navbar navbar-expand-lg navbar-dark navbar-admin mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('admin/dashboard') ?>">Espace Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navAdmin">
            <div class="navbar-nav ms-auto">
                <a class="nav-link text-white" href="<?= site_url('admin/prefixes') ?>">Préfixes</a>
                <a class="nav-link text-white" href="<?= site_url('admin/types-operation') ?>">Types & Barèmes</a>
                <a class="nav-link text-white" href="<?= site_url('admin/gains') ?>">Gains</a>
                <a class="nav-link text-white" href="<?= site_url('admin/comptes') ?>">Comptes clients</a>
                <a class="nav-link text-white" href="<?= site_url('admin/utilisateurs') ?>">Administrateurs</a>
                <a class="nav-link text-white" href="<?= site_url('admin/logout') ?>">Déconnexion (<?= esc(session()->get('admin_login')) ?>)</a>
            </div>
        </div>
    </div>
</nav>
<?php endif; ?>

<div class="container pb-5">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
