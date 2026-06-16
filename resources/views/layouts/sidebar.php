<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$perfilId = $_SESSION['id_perfil'] ?? '';
$isAdmin = $perfilId === '10';
$menuSections = [
    '01' => [
        'title' => 'OPCIONES CIUDADANO',
        'items' => [
            ['icon' => 'bi-plus-circle', 'label' => 'Registrar Solicitud', 'href' => url('/solicitudes/crear'), 'active' => str_ends_with($path, '/solicitudes/crear')],
            ['icon' => 'bi-file-earmark-text', 'label' => 'Mis Solicitudes', 'href' => url('/solicitudes'), 'active' => str_ends_with($path, '/solicitudes')],
        ],
    ],
    '02' => [
        'title' => 'TRANSPARENCIA',
        'items' => [
            ['icon' => 'bi-inboxes', 'label' => 'Bandeja de Entrada', 'href' => url('/modulos/bandeja-entrada'), 'active' => str_ends_with($path, '/modulos/bandeja-entrada')],
            ['icon' => 'bi-arrow-left-right', 'label' => 'Derivar Documentos', 'href' => url('/modulos/derivar-expedientes'), 'active' => str_ends_with($path, '/modulos/derivar-expedientes')],
        ],
    ],
    '03' => [
        'title' => 'JEFATURA',
        'items' => [
            ['icon' => 'bi-diagram-3', 'label' => 'Supervision', 'href' => url('/modulos/supervision'), 'active' => str_ends_with($path, '/modulos/supervision')],
            ['icon' => 'bi-graph-up', 'label' => 'Reportes', 'href' => url('/modulos/reportes'), 'active' => str_ends_with($path, '/modulos/reportes')],
            ['icon' => 'bi-clipboard-check', 'label' => 'Actualizar Estados', 'href' => url('/modulos/actualizar-estados'), 'active' => str_ends_with($path, '/modulos/actualizar-estados')],
            ['icon' => 'bi-paperclip', 'label' => 'Adjuntar Documentos', 'href' => url('/modulos/adjuntar-documentos'), 'active' => str_ends_with($path, '/modulos/adjuntar-documentos')],
        ],
    ],
    '04' => [
        'title' => 'ASISTENCIA',
        'items' => [
            ['icon' => 'bi-clipboard-check', 'label' => 'Actualizar Estados', 'href' => url('/modulos/actualizar-estados'), 'active' => str_ends_with($path, '/modulos/actualizar-estados')],
            ['icon' => 'bi-paperclip', 'label' => 'Adjuntar Documentos', 'href' => url('/modulos/adjuntar-documentos'), 'active' => str_ends_with($path, '/modulos/adjuntar-documentos')],
        ],
    ],
    '05' => [
        'title' => 'CONTROL ODANC',
        'items' => [
            ['icon' => 'bi-stopwatch', 'label' => 'Alertas SLA', 'href' => url('/modulos/alertas-sla'), 'active' => str_ends_with($path, '/modulos/alertas-sla')],
            ['icon' => 'bi-shield-exclamation', 'label' => 'Auditoria', 'href' => url('/modulos/auditoria'), 'active' => str_ends_with($path, '/modulos/auditoria')],
        ],
    ],
    '06' => [
        'title' => 'ARCHIVO',
        'items' => [
            ['icon' => 'bi-archive', 'label' => 'Busqueda Documental', 'href' => url('/modulos/busqueda-documental'), 'active' => str_ends_with($path, '/modulos/busqueda-documental')],
            ['icon' => 'bi-folder-check', 'label' => 'Preparar Anexos', 'href' => url('/modulos/preparar-anexos'), 'active' => str_ends_with($path, '/modulos/preparar-anexos')],
        ],
    ],
    '07' => [
        'title' => 'MESA DE PARTES',
        'items' => [
            ['icon' => 'bi-envelope-paper', 'label' => 'Validar Ingresos', 'href' => url('/modulos/validar-ingresos'), 'active' => str_ends_with($path, '/modulos/validar-ingresos')],
            ['icon' => 'bi-send-check', 'label' => 'Remitir Solicitudes', 'href' => url('/modulos/remitir-solicitudes'), 'active' => str_ends_with($path, '/modulos/remitir-solicitudes')],
        ],
    ],
    '08' => [
        'title' => 'SUPERVISION GENERAL',
        'items' => [
            ['icon' => 'bi-bar-chart', 'label' => 'Indicadores', 'href' => url('/modulos/indicadores'), 'active' => str_ends_with($path, '/modulos/indicadores')],
            ['icon' => 'bi-people', 'label' => 'Coordinacion', 'href' => url('/modulos/coordinacion'), 'active' => str_ends_with($path, '/modulos/coordinacion')],
        ],
    ],
    '09' => [
        'title' => 'AUDITORIA DE PLAZOS',
        'items' => [
            ['icon' => 'bi-stopwatch-fill', 'label' => 'Analisis SLA', 'href' => url('/modulos/analisis-sla'), 'active' => str_ends_with($path, '/modulos/analisis-sla')],
            ['icon' => 'bi-clipboard-data', 'label' => 'Incumplimientos', 'href' => url('/modulos/incumplimientos'), 'active' => str_ends_with($path, '/modulos/incumplimientos')],
        ],
    ],
    '10' => [
        'title' => 'ADMINISTRACION',
        'items' => [
            ['icon' => 'bi-person-gear', 'label' => 'Usuarios', 'href' => url('/modulos/usuarios'), 'active' => str_ends_with($path, '/modulos/usuarios')],
            ['icon' => 'bi-person-badge', 'label' => 'Perfiles', 'href' => url('/modulos/perfiles'), 'active' => str_ends_with($path, '/modulos/perfiles')],
            ['icon' => 'bi-sliders', 'label' => 'Catalogos', 'href' => url('/modulos/catalogos'), 'active' => str_ends_with($path, '/modulos/catalogos')],
            ['icon' => 'bi-life-preserver', 'label' => 'Soporte SLA', 'href' => url('/modulos/soporte-sla'), 'active' => str_ends_with($path, '/modulos/soporte-sla')],
            ['icon' => 'bi-credit-card', 'label' => 'Pagos Culqi', 'href' => url('/modulos/pagos-culqi'), 'active' => str_ends_with($path, '/modulos/pagos-culqi')],
            ['icon' => 'bi-journal-check', 'label' => 'Registro Auditoria', 'href' => url('/modulos/auditoria-sistema'), 'active' => str_ends_with($path, '/modulos/auditoria-sistema')],
        ],
    ],
];
$visibleSections = $isAdmin ? $menuSections : array_intersect_key($menuSections, [$perfilId => true]);
?>
<div id="sidebar" class="sidebar-fixed">
    <div class="d-flex flex-column h-100">
        <div class="text-center py-4 px-3">
            <img src="<?= asset('img/poderjudicial.png') ?>" alt="Logo PJ" width="60" class="mb-2">
            <h6 class="text-pj-gold fw-bold mb-0" style="letter-spacing: 1px; font-size: 0.9rem;">PODER JUDICIAL</h6>
            <small class="text-white-50 text-uppercase" style="font-size: 0.65rem;">Casillero Digital</small>
        </div>
        <hr class="mx-3 text-white-50">
        <div class="mb-4 text-center">
            <div class="bg-light rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                <i class="bi bi-person-fill text-pj-blue fs-3"></i>
            </div>
            <span class="d-block text-white small fw-bold"><?= e($_SESSION['nombre_usuario'] ?? '') ?></span>
            <span class="badge rounded-pill bg-pj-gold text-white mt-1" style="font-size: 0.65rem;">
                <i class="bi bi-shield-lock-fill me-1"></i><?= e($_SESSION['nombre_perfil'] ?? '') ?>
            </span>
        </div>
        <nav class="flex-grow-1">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="<?= url('/dashboard') ?>" class="nav-link text-white mb-2 <?= str_ends_with($path, '/dashboard') ? 'active' : '' ?>">
                        <i class="bi bi-house-door me-2"></i> Inicio
                    </a>
                </li>
                <?php foreach ($visibleSections as $key => $section): ?>
                    <?php
                        $collapseId = 'menu_' . $key;
                        $hasActiveItem = array_filter($section['items'], fn ($item) => !empty($item['active']));
                        $expanded = !$isAdmin || !empty($hasActiveItem) || $key === '10';
                    ?>
                    <li class="nav-item">
                        <button class="sidebar-section-toggle <?= $expanded ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= e($collapseId) ?>" aria-expanded="<?= $expanded ? 'true' : 'false' ?>">
                            <span><i class="bi bi-chevron-down me-2"></i><?= e($section['title']) ?></span>
                        </button>
                    </li>
                    <div id="<?= e($collapseId) ?>" class="collapse <?= $expanded ? 'show' : '' ?>">
                    <?php foreach ($section['items'] as $item): ?>
                        <li>
                            <?php if (!empty($item['href'])): ?>
                                <a href="<?= e($item['href']) ?>" class="nav-link text-white mb-2 <?= !empty($item['active']) ? 'active' : '' ?>">
                                    <i class="bi <?= e($item['icon']) ?> me-2"></i> <?= e($item['label']) ?>
                                </a>
                            <?php else: ?>
                                <span class="nav-link text-white-50 mb-2">
                                    <i class="bi <?= e($item['icon']) ?> me-2"></i> <?= e($item['label']) ?>
                                </span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </ul>
        </nav>
        <div class="mt-auto p-3 border-top border-white border-opacity-10">
            <a href="<?= url('/logout') ?>" class="btn btn-outline-danger btn-sm w-100 d-flex align-items-center justify-content-center text-white">
                <i class="bi bi-box-arrow-left me-2"></i> Cerrar Sesion
            </a>
        </div>
    </div>
</div>
