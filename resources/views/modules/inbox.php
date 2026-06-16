<?php
$title = 'Bandeja de Entrada';
ob_start();
?>
<div class="inbox-shell">
    <aside class="inbox-folders">
        <div class="inbox-account">
            <div class="small text-white-50">Casillero Digital</div>
            <div class="fw-bold text-white">transparencia@pj.gob.pe</div>
        </div>
        <button class="inbox-folder active" type="button" data-filter="all">
            <span><i class="bi bi-inbox me-2"></i>Bandeja de entrada</span>
            <strong data-count="all"><?= count($rows) ?></strong>
        </button>
        <button class="inbox-folder" type="button" data-filter="pending"><span><i class="bi bi-file-earmark-text me-2"></i>Pendientes</span><strong data-count="pending">0</strong></button>
        <button class="inbox-folder" type="button" data-filter="derived"><span><i class="bi bi-send me-2"></i>Derivadas</span><strong data-count="derived">0</strong></button>
        <button class="inbox-folder" type="button" data-filter="process"><span><i class="bi bi-clock-history me-2"></i>En tramite</span><strong data-count="process">0</strong></button>
        <button class="inbox-folder" type="button" data-filter="answered"><span><i class="bi bi-check-circle me-2"></i>Atendidas</span><strong data-count="answered">0</strong></button>
        <button class="inbox-folder" type="button" data-filter="expired"><span><i class="bi bi-exclamation-triangle me-2"></i>Vencidas</span><strong data-count="expired">0</strong></button>
    </aside>

    <section class="inbox-list">
        <?php if (old_query('msg') === 'derivado'): ?>
            <div class="alert alert-success rounded-0 mb-0 small">
                Solicitud derivada. El ciudadano ahora vera el estado EN PROCESO.
            </div>
        <?php endif; ?>
        <div class="inbox-toolbar">
            <div>
                <button class="inbox-tab active" type="button" data-filter="all">Todo</button>
                <button class="inbox-tab" type="button" data-filter="unread">No leidos <span class="ms-1" data-count="unread">0</span></button>
            </div>
            <span class="small text-muted">Por fecha <i class="bi bi-arrow-down-up ms-1"></i></span>
        </div>

        <?php if (empty($rows)): ?>
            <div class="text-center text-muted py-5">No hay solicitudes en la bandeja.</div>
        <?php endif; ?>

        <?php foreach ($rows as $index => $row): ?>
            <?php
                $estado = strtoupper($row['Estado'] ?? 'PENDIENTE');
                $folder = match ($estado) {
                    'ATENDIDO' => 'answered',
                    'VENCIDO' => 'expired',
                    'EN PROCESO' => str_starts_with(strtoupper($row['Observacion'] ?? ''), 'DERIVADO A:') ? 'derived' : 'process',
                    'CON PRÓRROGA', 'CON PRORROGA' => 'process',
                    default => 'pending',
                };
            ?>
            <button class="inbox-message is-unread" type="button" data-id="<?= e((string) ($row['Solicitud'] ?? $index)) ?>" data-target="msg_<?= $index ?>" data-folder="<?= e($folder) ?>">
                <div class="d-flex justify-content-between align-items-start gap-2">
                    <div class="text-start">
                        <div class="message-title text-truncate">Solicitud #<?= e((string) ($row['Solicitud'] ?? '')) ?></div>
                        <div class="small text-pj-blue text-truncate"><?= e($row['Usuario'] ?? 'Usuario no registrado') ?></div>
                    </div>
                    <span class="small text-muted"><?= !empty($row['Registro']) ? date('d/m H:i', strtotime($row['Registro'])) : '' ?></span>
                </div>
                <div class="small text-muted text-start text-truncate mt-1">
                    <?= e($row['Corte'] ?? 'Sin corte') ?> - <?= e($row['Estado'] ?? 'Pendiente') ?>
                </div>
            </button>
        <?php endforeach; ?>
    </section>

    <section class="inbox-preview">
        <div class="inbox-empty">
            <i class="bi bi-envelope fs-1"></i>
            <h5>Seleccione un elemento para leer</h5>
            <p>Los mensajes nuevos quedan en negrita y en No leidos hasta que los abra.</p>
        </div>

        <?php foreach ($rows as $index => $row): ?>
            <?php $archivos = array_filter(explode('||', $row['Archivos'] ?? '')); ?>
            <article class="inbox-detail" id="msg_<?= $index ?>">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="badge bg-pj-gold text-pj-blue mb-2"><?= e($module['seccion']) ?></span>
                        <h4 class="fw-bold text-pj-blue mb-1">Solicitud #<?= e((string) ($row['Solicitud'] ?? '')) ?></h4>
                        <p class="text-muted small mb-0"><?= e($row['Usuario'] ?? '') ?> - <?= e($row['Corte'] ?? '') ?></p>
                    </div>
                    <span class="badge bg-primary"><?= e($row['Estado'] ?? 'Pendiente') ?></span>
                </div>
                <div class="inbox-detail-card">
                    <div class="row g-3 small">
                        <div class="col-md-6"><strong>Registro:</strong><br><?= !empty($row['Registro']) ? date('d/m/Y H:i', strtotime($row['Registro'])) : '-' ?></div>
                        <div class="col-md-6"><strong>Corte:</strong><br><?= e($row['Corte'] ?? '-') ?></div>
                        <div class="col-md-12"><strong>Accion sugerida:</strong><br>Revisar la solicitud, validar competencia y derivar al area responsable.</div>
                    </div>
                </div>

                <div class="inbox-expanded-detail mt-3" id="detail_<?= $index ?>">
                    <div class="inbox-detail-card mb-3">
                        <h6 class="text-pj-gold fw-bold text-uppercase small mb-3">Detalle del pedido</h6>
                        <p class="mb-0"><?= nl2br(e($row['Sustento'] ?? 'Sin sustento registrado.')) ?></p>
                    </div>
                    <div class="inbox-detail-card mb-3">
                        <h6 class="text-pj-blue fw-bold mb-3"><i class="bi bi-geo-alt me-2"></i>Datos de notificacion</h6>
                        <div class="row g-3 small">
                            <div class="col-md-6"><strong>Direccion:</strong><br><?= e($row['Direccion'] ?? '-') ?></div>
                            <div class="col-md-6"><strong>Ubigeo:</strong><br><?= e($row['Ubigeo'] ?? '-') ?></div>
                            <div class="col-md-6"><strong>Celular:</strong><br><?= e($row['Celular'] ?? '-') ?></div>
                            <div class="col-md-6"><strong>Telefono:</strong><br><?= e($row['Telefono'] ?? '-') ?></div>
                        </div>
                    </div>
                    <div class="inbox-detail-card">
                        <h6 class="text-pj-blue fw-bold mb-3"><i class="bi bi-paperclip me-2"></i>Archivos enviados por el ciudadano</h6>
                        <?php if (empty($archivos)): ?>
                            <p class="text-muted small mb-0">No se adjuntaron archivos.</p>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($archivos as $archivo): ?>
                                    <div class="list-group-item px-0 small d-flex align-items-center">
                                        <i class="bi bi-file-earmark-text text-pj-blue me-2"></i>
                                        <?= e($archivo) ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mt-4 d-flex flex-wrap gap-2">
                    <button class="btn btn-pj-blue btn-sm inbox-inline-detail" type="button" data-detail="detail_<?= $index ?>">
                        <i class="bi bi-eye me-1"></i> Ver detalle
                    </button>
                    <button class="btn btn-outline-primary btn-sm inbox-derive" type="button" data-bs-toggle="modal" data-bs-target="#deriveModal" data-request="<?= e((string) ($row['Solicitud'] ?? '')) ?>" data-user="<?= e($row['Usuario'] ?? '') ?>" data-corte="<?= e($row['CorteCodigo'] ?? '') ?>">
                        <i class="bi bi-arrow-left-right me-1"></i> Derivar
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" type="button">
                        <i class="bi bi-archive me-1"></i> Archivar
                    </button>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
</div>

<div class="modal fade" id="deriveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-pj-blue text-white">
                <h5 class="modal-title"><i class="bi bi-arrow-left-right me-2"></i>Derivar solicitud</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= url('/modulos/derivar') ?>" method="POST">
            <div class="modal-body">
                <div class="alert alert-info small">
                    La derivacion normal es: Transparencia valida el pedido, identifica la competencia y envia los documentos al area que conserva o administra la informacion. Luego esa area prepara la respuesta o anexos, y Transparencia cierra la atencion.
                </div>
                <input type="hidden" name="c_solicitud" id="deriveRequestId">
                <input type="hidden" name="c_corte" id="deriveCourt">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Solicitud</label>
                        <input id="deriveRequest" class="form-control form-control-sm" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Ciudadano</label>
                        <input id="deriveUser" class="form-control form-control-sm" readonly>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Destino recomendado</label>
                        <select id="deriveTarget" name="destino" class="form-select form-select-sm">
                            <option>Secretaria General - lo revisa Jefatura o Asistencia Administrativa</option>
                            <option>Archivo Central - lo revisa Tecnico de Archivo</option>
                            <option>Administracion de Corte - lo revisa Jefatura Administrativa</option>
                            <option>ODANC - lo revisa Responsable ODANC o Auditor de Plazos</option>
                            <option>Mesa de Partes - lo revisa Mesa de Partes</option>
                        </select>
                        <div class="form-text">
                            El destino es un area; la cuenta que lo atiende depende del perfil interno asignado a esa area.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold">Observacion de derivacion</label>
                        <textarea name="observacion" class="form-control" rows="3">Se deriva para evaluar competencia, ubicar la informacion solicitada y remitir respuesta documentada.</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-pj-blue" id="confirmDerive">Confirmar derivacion</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
ob_start();
?>
<script>
const readKey = 'casillero_read_messages';
const readMessages = new Set(JSON.parse(localStorage.getItem(readKey) || '[]'));
let activeFilter = 'all';

function persist(key, set) {
    localStorage.setItem(key, JSON.stringify([...set]));
}

function folderOf(message) {
    return message.dataset.folder;
}

function updateInboxState() {
    const messages = [...document.querySelectorAll('.inbox-message')];
    const counts = { all: 0, unread: 0, pending: 0, derived: 0, process: 0, answered: 0, expired: 0 };

    messages.forEach((message) => {
        const id = message.dataset.id;
        const isRead = readMessages.has(id);
        const folder = folderOf(message);
        message.classList.toggle('is-unread', !isRead);
        counts.all++;
        counts[folder] = (counts[folder] || 0) + 1;
        if (!isRead) counts.unread++;

        const visible = activeFilter === 'all'
            || (activeFilter === 'unread' && !isRead)
            || activeFilter === folder;
        message.classList.toggle('d-none', !visible);
    });

    Object.entries(counts).forEach(([key, value]) => {
        document.querySelectorAll(`[data-count="${key}"]`).forEach((item) => item.textContent = value);
    });
}

function setFilter(filter) {
    activeFilter = filter;
    document.querySelectorAll('.inbox-tab, .inbox-folder').forEach((item) => item.classList.remove('active'));
    document.querySelectorAll(`[data-filter="${filter}"]`).forEach((item) => item.classList.add('active'));
    updateInboxState();
}

document.querySelectorAll('.inbox-message').forEach((button) => {
    button.addEventListener('click', () => {
        readMessages.add(button.dataset.id);
        persist(readKey, readMessages);
        document.querySelectorAll('.inbox-message').forEach((item) => item.classList.remove('active'));
        document.querySelectorAll('.inbox-detail').forEach((item) => item.classList.remove('active'));
        document.querySelector('.inbox-empty')?.classList.add('d-none');
        button.classList.add('active');
        document.getElementById(button.dataset.target)?.classList.add('active');
        updateInboxState();
    });
});
document.querySelectorAll('.inbox-tab, .inbox-folder').forEach((item) => {
    item.addEventListener('click', () => setFilter(item.dataset.filter || 'all'));
});
document.querySelectorAll('.inbox-inline-detail').forEach((button) => {
    button.addEventListener('click', () => {
        const detail = document.getElementById(button.dataset.detail);
        detail?.classList.toggle('show');
        button.innerHTML = detail?.classList.contains('show')
            ? '<i class="bi bi-eye-slash me-1"></i> Ocultar detalle'
            : '<i class="bi bi-eye me-1"></i> Ver detalle';
        detail?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });
});
document.querySelectorAll('.inbox-derive').forEach((button) => {
    button.addEventListener('click', () => {
        document.getElementById('deriveRequestId').value = button.dataset.request;
        document.getElementById('deriveCourt').value = button.dataset.corte;
        document.getElementById('deriveRequest').value = `Solicitud #${button.dataset.request}`;
        document.getElementById('deriveUser').value = button.dataset.user;
    });
});
updateInboxState();
</script>
<?php
$scripts = ob_get_clean();
require dirname(__DIR__) . '/layouts/app.php';
?>
