<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Espace Opérateur' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php if (session()->get('operateur_connecte')): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('operateur/dashboard') ?>">Espace Opérateur</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link text-white" href="<?= site_url('operateur/prefixes') ?>">Préfixes</a>
            <a class="nav-link text-white" href="<?= site_url('operateur/types-operation') ?>">Types & Barèmes</a>
            <a class="nav-link text-white" href="<?= site_url('operateur/gains') ?>">Gains</a>
            <a class="nav-link text-white" href="<?= site_url('operateur/comptes') ?>">Comptes clients</a>
            <a class="nav-link text-white" href="<?= site_url('operateur/logout') ?>">Déconnexion</a>
        </div>
    </div>
</nav>
<?php endif; ?>

<div class="container">
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
