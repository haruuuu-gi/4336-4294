<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<h5 class="section-title admin">👥 Situation des comptes clients</h5>

<table class="table table-admin table-striped bg-white shadow-sm">
    <thead>
        <tr>
            <th>Téléphone</th>
            <th>Solde</th>
            <th>Nb opérations</th>
            <th>Créé le</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($comptes)): ?>
        <tr><td colspan="4" class="text-center text-muted">Aucun compte client pour le moment.</td></tr>
    <?php endif; ?>
    <?php foreach ($comptes as $c): ?>
        <tr>
            <td><?= esc($c['telephone']) ?></td>
            <td><?= number_format($c['solde'], 0, ',', ' ') ?> Ar</td>
            <td><?= (int) $c['nb_operations'] ?></td>
            <td><?= esc($c['created_at']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr class="fw-bold">
            <td>Total</td>
            <td><?= number_format($totalSolde, 0, ',', ' ') ?> Ar</td>
            <td colspan="2"></td>
        </tr>
    </tfoot>
</table>

<?= $this->endSection() ?>
