<?php $title = 'Mis Solicitudes'; ob_start(); ?>
<div class="container-fluid p-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between">
            <h6 class="mb-0 fw-bold text-pj-blue"><i class="bi bi-list-task me-2"></i>Estado de mis tramites</h6>
            <a href="<?= url('/solicitudes/crear') ?>" class="btn btn-sm btn-pj-blue">Nueva Solicitud</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light"><tr class="small text-uppercase"><th>ID</th><th>Fecha</th><th>Sede Judicial</th><th>Area</th><th>Estado SLA</th><th class="text-center">Acciones</th></tr></thead>
                    <tbody>
                    <?php foreach ($solicitudes as $row): $sla = calcularSLA($row['f_registro'], (int) $row['n_tiempo_atencion'], (int) $row['n_tiempo_prorroga']); ?>
                        <tr>
                            <td class="fw-bold">#<?= str_pad($row['c_solicitud'], 6, '0', STR_PAD_LEFT) ?></td>
                            <td class="small"><?= date('d/m/Y H:i', strtotime($row['f_registro'])) ?></td>
                            <td><span class="badge bg-pj-blue"><?= e($row['x_corte']) ?></span></td>
                            <td class="small text-muted"><?= e($row['area_actual']) ?></td>
                            <td><span class="badge bg-<?= $sla['color'] ?>-subtle text-<?= $sla['color'] ?> border border-<?= $sla['color'] ?>"><?= e($sla['texto']) ?></span></td>
                            <td class="text-center"><a href="<?= url('/solicitudes/detalle?id=' . $row['c_solicitud']) ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye-fill"></i> Ver Detalle</a></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($solicitudes)): ?><tr><td colspan="6" class="text-center text-muted py-4">No tiene solicitudes registradas.</td></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); require dirname(__DIR__) . '/layouts/app.php'; ?>
