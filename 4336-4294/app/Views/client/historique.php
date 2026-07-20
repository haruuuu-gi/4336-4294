<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h5 class="section-title">📜 Historique des opérations</h5>

<div class="table-responsive">
    <table class="table table-striped bg-white shadow-sm">
        <thead>
        <tr>
            <th>Date</th>
            <th>Opération</th>
            <th>Montant</th>
            <th>Frais retrait</th>
            <th>Commission</th>
            <th>Destinataire</th>
            <th>Solde après</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($historique)): ?>
            <tr><td colspan="7" class="text-center text-muted">Aucune opération pour le moment.</td></tr>
        <?php endif; ?>
        <?php foreach ($historique as $h): ?>
            <tr>
                <td><?= esc($h['created_at']) ?></td>
                <td><?= esc($h['operation_libelle']) ?></td>
                <td><?= number_format($h['montant'], 0, ',', ' ') ?> Ar</td>
                <td><?= number_format($h['frais'], 0, ',', ' ') ?> Ar</td>
                <td><?= number_format($h['commission'] ?? 0, 0, ',', ' ') ?> Ar</td>
                <td><?= $h['telephone_dest'] ? esc($h['telephone_dest']) : '-' ?></td>
                <td><?= number_format($h['solde_apres'], 0, ',', ' ') ?> Ar</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>
