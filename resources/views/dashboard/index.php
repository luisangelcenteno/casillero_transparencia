<?php
$title = 'Dashboard';
$withChart = true;
ob_start();
?>
<div class="container-fluid dashboard-page">
    <?php if (old_query('msg') === 'solicitud_enviada'): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0">
            <strong>Solicitud registrada.</strong> Su pedido fue enviado exitosamente.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row mb-4">
        <div class="col-lg-8">
            <h4 class="text-pj-blue fw-bold">Resumen de Actividad</h4>
            <p class="text-muted small">Estado actual segun el perfil asignado a su cuenta.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <span class="badge bg-<?= e($perfil['color']) ?> px-3 py-2">
                <i class="bi <?= e($perfil['icono']) ?> me-1"></i>
                Perfil <?= e($_SESSION['id_perfil'] ?? '') ?>: <?= e($_SESSION['nombre_perfil'] ?? $perfil['titulo']) ?>
            </span>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4 role-summary">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">
                <div class="col-md-7">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape bg-<?= e($perfil['color']) ?> bg-opacity-10 me-3">
                            <i class="bi <?= e($perfil['icono']) ?> fs-3 text-<?= e($perfil['color']) ?>"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold text-pj-blue"><?= e($perfil['titulo']) ?></h5>
                            <p class="mb-0 text-muted small"><?= e($perfil['descripcion']) ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="d-flex flex-wrap gap-2 justify-content-md-end role-actions">
                        <?php foreach ($perfil['acciones'] as $accion): ?>
                            <span class="badge bg-light text-dark border py-2 px-3"><?= e($accion) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-3"><div class="card card-stat bg-pj-blue shadow-sm text-white"><div class="card-body"><h6 class="text-pj-gold small fw-bold">Total Pedidos</h6><h2><?= $resumen['total'] ?></h2></div></div></div>
        <div class="col-md-3"><div class="card card-stat bg-white shadow-sm border-start border-primary border-5"><div class="card-body"><h6 class="text-primary small fw-bold">En Tramite</h6><h2><?= $resumen['proceso'] ?></h2></div></div></div>
        <div class="col-md-3"><div class="card card-stat bg-white shadow-sm border-start border-success border-5"><div class="card-body"><h6 class="text-success small fw-bold">Respuestas</h6><h2><?= $resumen['atendidas'] ?></h2></div></div></div>
        <div class="col-md-3"><div class="card card-stat bg-white shadow-sm border-start border-danger border-5"><div class="card-body"><h6 class="text-danger small fw-bold">Excedidas</h6><h2><?= $resumen['vencidas'] ?></h2></div></div></div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h6 class="text-pj-blue fw-bold mb-4"><i class="bi bi-pie-chart-fill me-2"></i>Distribucion de Estados</h6>
                    <div style="position: relative; height:250px;"><canvas id="chartSolicitudes"></canvas></div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-pj-blue text-white dashboard-info-card">
                <div class="card-body d-flex align-items-center p-4">
                    <div>
                        <h4 class="text-pj-gold fw-bold"><?= e($perfil['titulo']) ?></h4>
                        <p class="mb-0"><?= e($perfil['descripcion']) ?></p>
                        <?php if (($_SESSION['id_perfil'] ?? '') === '01'): ?>
                            <a href="<?= url('/solicitudes/crear') ?>" class="btn btn-outline-light btn-sm mt-3">Registrar solicitud <i class="bi bi-arrow-right"></i></a>
                        <?php else: ?>
                            <span class="badge bg-light text-pj-blue mt-3">Vista operativa del perfil</span>
                        <?php endif; ?>
                    </div>
                    <i class="bi bi-info-circle-fill opacity-25 ms-auto" style="font-size: 8rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mt-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold text-pj-blue"><i class="bi bi-clock-history me-2"></i>Solicitudes Recientes</h6>
            <a href="<?= url('/solicitudes') ?>" class="btn btn-sm btn-link text-pj-gold fw-bold text-decoration-none">Ver todas</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light"><tr class="small text-uppercase text-muted"><th>ID</th><th>Fecha</th><th>Corte</th><th>SLA</th><th>Area</th><th class="text-end">Acciones</th></tr></thead>
                    <tbody>
                    <?php if (empty($recientes)): ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">No tiene solicitudes registradas.</td></tr>
                    <?php endif; ?>
                    <?php foreach ($recientes as $row): $sla = calcularSLA($row['f_registro'], (int) $row['n_tiempo_atencion'], (int) $row['n_tiempo_prorroga']); ?>
                        <tr>
                            <td class="fw-bold text-pj-blue">#<?= str_pad($row['c_solicitud'], 6, '0', STR_PAD_LEFT) ?></td>
                            <td class="small"><?= date('d/m/Y', strtotime($row['f_registro'])) ?></td>
                            <td><span class="badge bg-pj-blue"><?= e($row['x_corte']) ?></span></td>
                            <td><span class="badge bg-<?= $sla['color'] ?>-subtle text-<?= $sla['color'] ?>"><?= e($sla['texto']) ?></span></td>
                            <td class="small text-muted"><?= e($row['area_actual']) ?></td>
                            <td class="text-end"><a href="<?= url('/solicitudes/detalle?id=' . $row['c_solicitud']) ?>" class="btn btn-sm btn-light border">Ver</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
ob_start();
?>
<script>
new Chart(document.getElementById('chartSolicitudes').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: ['En Tramite', 'Atendidas', 'Vencidas'],
        datasets: [{ data: [<?= $resumen['proceso'] ?>, <?= $resumen['atendidas'] ?>, <?= $resumen['vencidas'] ?>], backgroundColor: ['#0d6efd', '#198754', '#dc3545'], borderWidth: 0 }]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, cutout: '75%' }
});
</script>
<?php
$scripts = ob_get_clean();
require dirname(__DIR__) . '/layouts/app.php';
