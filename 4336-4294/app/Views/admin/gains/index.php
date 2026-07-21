<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<h5 class="section-title admin">📈 Situation des gains (frais perçus)</h5>

<table class="table table-admin table-striped bg-white shadow-sm">
    <thead>
        <tr>
            <th>Opération</th>
            <th>Catégorie</th>
            <th>Nombre d'opérations</th>
            <th>Total des frais perçus</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($gains as $g): ?>
        <tr>
            <td><?= esc($g['operation']) ?></td>
            <td><?= esc($g['categorie']) ?></td>
            <td><?= (int) $g['nb_operations'] ?></td>
            <td><?= number_format($g['total_frais'], 0, ',', ' ') ?> Ar</td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr class="fw-bold">
            <td colspan="3">Total général</td>
            <td><?= number_format($totalGeneral, 0, ',', ' ') ?> Ar</td>
        </tr>
    </tfoot>
</table>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h5 class="section-title admin mt-4">� Détail des transferts</h5>

<table class="table table-admin table-striped bg-white shadow-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Envoyeur</th>
            <th>Destinataire</th>
            <th>Montant</th>
            <th>Frais opérateur</th>
            <th>Commission externe</th>
            <th>Total débité</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($transfertsDetails)): ?>
        <tr><td colspan="8" class="text-center text-muted">Aucun transfert à afficher.</td></tr>
    <?php endif; ?>
    <?php foreach ($transfertsDetails as $t): ?>
        <tr>
            <td><?= (int) $t['id'] ?></td>
            <td><?= date_format(new DateTime($t['created_at']), 'd/m/Y') ?></td>
            <td><?= esc($t['telephone_envoyeur']) ?></td>
            <td><?= esc($t['telephone_destinataire']) ?></td>
            <td><?= number_format($t['montant'], 0, ',', ' ') ?> Ar</td>
            <td><?= number_format($t['frais_operateur'], 0, ',', ' ') ?> Ar</td>
            <td><?= number_format($t['commission_externe'], 0, ',', ' ') ?> Ar</td>
            <td><?= number_format($t['total_debite'], 0, ',', ' ') ?> Ar</td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
