<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Golden Money' ?></title>
    <link href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body class="bg-page">
<header class="site-header py-3 mb-4">
    <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
        <div>
            <a class="brand" href="<?= site_url('client/dashboard') ?>">Golden Money</a>
            <p class="brand-subtitle mb-0">Secure your money</p>
        </div>
        <?php if (session()->get('compte_id')): ?>
            <div class="header-actions d-flex flex-wrap gap-2 align-items-center">
                <span class="badge badge-primary">Client : <?= esc(session()->get('telephone')) ?></span>
                <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('client/depot') ?>">Dépôt</a>
                <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('client/transfert') ?>">Transfert</a>
                <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('client/retrait') ?>">Retrait</a>
                <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('client/historique') ?>">Historique</a>
                <a class="btn btn-sm btn-light" href="<?= site_url('client/logout') ?>">Déconnexion</a>
            </div>
        <?php endif; ?>
    </div>
</header>

<main class="container pb-5">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success shadow-sm"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger shadow-sm"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</main>

<script src="<?= base_url('bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
