<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<h5 class="section-title admin">📈 Situation des gains (frais perçus)</h5>

<table class="table table-admin table-striped bg-white shadow-sm">
    <thead><tr><th>Opération</th><th>Nombre d'opérations</th><th>Total des frais perçus</th></tr></thead>
    <tbody>
    <?php foreach ($gains as $g): ?>
        <tr>
            <td><?= esc($g['operation']) ?></td>
            <td><?= (int) $g['nb_operations'] ?></td>
            <td><?= number_format($g['total_frais'], 0, ',', ' ') ?> Ar</td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr class="fw-bold">
            <td colspan="2">Total général</td>
            <td><?= number_format($totalGeneral, 0, ',', ' ') ?> Ar</td>
        </tr>
    </tfoot>
</table>

<?= $this->endSection() ?>
