<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<h5 class="section-title admin">✏️ Modifier une tranche — <?= esc($type['libelle'] ?? '') ?></h5>
<a href="<?= site_url('admin/types-operation/' . $type['id'] . '/baremes') ?>" class="btn btn-sm btn-outline-secondary mb-3">&larr; Retour au barème</a>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="post" action="<?= site_url('admin/baremes/' . $bareme['id'] . '/update') ?>">
            <?= csrf_field() ?>
            <div class="mb-2">
                <label class="form-label">Montant min (Ar)</label>
                <input type="number" step="1" name="montant_min" class="form-control" value="<?= esc($bareme['montant_min']) ?>" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Montant max (Ar)</label>
                <input type="number" step="1" name="montant_max" class="form-control" value="<?= esc($bareme['montant_max']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Frais (Ar)</label>
                <input type="number" step="1" name="frais" class="form-control" value="<?= esc($bareme['frais']) ?>" required>
            </div>
            <button type="submit" class="btn btn-dark">Mettre à jour</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
