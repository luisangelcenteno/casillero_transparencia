<?php
$title = 'Detalle de Solicitud';
$backUrl = $_SERVER['HTTP_REFERER'] ?? url('/solicitudes');
ob_start();
?>
<div class="container-fluid p-4">
    <?php if (old_query('msg') === 'apoyo'): ?>
        <div class="alert alert-success border-0 shadow-sm">
            <i class="bi bi-check-circle me-2"></i>
            Solicitud de apoyo registrada para Administracion del Sistema.
        </div>
    <?php elseif (old_query('msg') === 'chat'): ?>
        <div class="alert alert-success border-0 shadow-sm">
            <i class="bi bi-chat-dots me-2"></i>
            Mensaje enviado. Administracion del Sistema lo revisara desde Soporte SLA.
        </div>
    <?php elseif (old_query('msg') === 'pago'): ?>
        <div class="alert alert-success border-0 shadow-sm">
            <i class="bi bi-credit-card me-2"></i>
            Pago Culqi Online demo registrado. La copia solicitada queda habilitada para coordinacion de entrega.
        </div>
    <?php elseif (old_query('error') === 'apoyo'): ?>
        <div class="alert alert-danger border-0 shadow-sm">
            <i class="bi bi-exclamation-triangle me-2"></i>
            No se pudo registrar la solicitud de apoyo.
        </div>
    <?php elseif (old_query('error') === 'pago'): ?>
        <div class="alert alert-danger border-0 shadow-sm">
            <i class="bi bi-exclamation-triangle me-2"></i>
            No se pudo registrar el pago de reproduccion.
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-pj-blue fw-bold mb-0">Solicitud #<?= str_pad($solicitud['c_solicitud'], 6, '0', STR_PAD_LEFT) ?></h3>
            <span class="text-muted small">Fecha: <?= date('d/m/Y', strtotime($solicitud['f_registro'])) ?></span>
        </div>
        <a href="<?= e($backUrl) ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Volver</a>
    </div>
    <div class="row">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body">
                    <h6 class="text-pj-gold fw-bold text-uppercase small mb-3">Detalle del Pedido</h6>
                    <p class="text-dark bg-light p-3 rounded border"><?= nl2br(e($solicitud['x_sustentacion'])) ?></p>
                    <hr>
                    <h6 class="text-pj-gold fw-bold text-uppercase small mb-3">Datos de Notificacion</h6>
                    <div class="row g-2 small">
                        <div class="col-6"><strong>Direccion:</strong> <?= e($solicitud['x_tipo_via'] . ' ' . $solicitud['x_nombre_via']) ?></div>
                        <div class="col-6"><strong>Ubigeo:</strong> <?= e($solicitud['x_distrito'] . ', ' . $solicitud['x_provincia'] . ' - ' . $solicitud['x_departamento']) ?></div>
                        <div class="col-6"><strong>Celular:</strong> <?= e($solicitud['x_celular']) ?></div>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h6 class="text-pj-blue fw-bold mb-3"><i class="bi bi-paperclip me-2"></i>Anexos</h6>
                    <?php if (empty($anexos)): ?><p class="text-muted small">No se adjuntaron documentos.</p><?php endif; ?>
                    <?php foreach ($anexos as $anexo): ?>
                        <div class="list-group-item border-0 small d-flex justify-content-between align-items-center gap-2">
                            <span><i class="bi bi-file-earmark me-2"></i><?= e($anexo['x_archivo']) ?></span>
                            <div class="text-nowrap">
                                <a href="<?= url('/documentos/anexo?id=' . (int) $anexo['c_solicitud_anexo']) ?>" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener">
                                    <i class="bi bi-eye"></i> Ver
                                </a>
                                <button type="button"
                                        class="btn btn-sm btn-outline-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#supportModal"
                                        data-anexo="<?= (int) $anexo['c_solicitud_anexo'] ?>"
                                        data-archivo="<?= e($anexo['x_archivo']) ?>">
                                    <i class="bi bi-life-preserver"></i> Reportar
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-body">
                    <h6 class="text-pj-blue fw-bold mb-3"><i class="bi bi-file-earmark-check me-2"></i>Respuestas</h6>
                    <?php if (empty($respuestas)): ?><p class="text-muted small">Aun no se registro una respuesta firmada.</p><?php endif; ?>
                    <?php foreach ($respuestas as $respuesta): ?>
                        <?php
                            $verificationCode = 'CDT-' . str_pad((string) $solicitud['c_solicitud'], 6, '0', STR_PAD_LEFT)
                                . '-' . str_pad((string) $respuesta['c_solicitud_respuesta'], 6, '0', STR_PAD_LEFT);
                        ?>
                        <div class="list-group-item border-0 small d-flex justify-content-between align-items-center gap-3">
                            <div>
                                <div>
                                    <i class="bi bi-file-earmark-lock me-2"></i><?= e($respuesta['x_archivo']) ?>
                                    <span class="text-muted ms-2"><?= date('d/m/Y H:i', strtotime($respuesta['f_registro'])) ?></span>
                                </div>
                                <div class="text-success mt-1">
                                    <i class="bi bi-bell me-1"></i>
                                    Notificacion enviada: respuesta firmada disponible.
                                    <span class="text-muted ms-2">Codigo: <?= e($verificationCode) ?></span>
                                </div>
                            </div>
                            <button type="button"
                                    class="btn btn-sm btn-pj-blue text-nowrap"
                                    data-bs-toggle="modal"
                                    data-bs-target="#signedCitizenModal"
                                    data-url="<?= e(url('/documentos/firmado?id=' . (int) $respuesta['c_solicitud_respuesta'])) ?>">
                                <i class="bi bi-eye"></i> Ver firmado
                            </button>
                            <button type="button"
                                    class="btn btn-sm btn-outline-primary text-nowrap"
                                    data-bs-toggle="modal"
                                    data-bs-target="#paymentModal"
                                    data-respuesta="<?= (int) $respuesta['c_solicitud_respuesta'] ?>"
                                    data-documento="<?= e($respuesta['x_archivo']) ?>">
                                <i class="bi bi-credit-card"></i> Solicitar copia
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php if (!empty($reproductionPayments ?? [])): ?>
                <div class="card border-0 shadow-sm rounded-4 mt-4">
                    <div class="card-body">
                        <h6 class="text-pj-blue fw-bold mb-3"><i class="bi bi-receipt me-2"></i>Pagos de reproduccion</h6>
                        <?php foreach ($reproductionPayments as $payment): ?>
                            <?php
                                $copyReady = !empty($payment['x_copia_ubicacion']);
                                $copyUrl = url('/documentos/copia-pagada?id=' . (int) $payment['c_pago_reproduccion']);
                            ?>
                            <div class="list-group-item border-0 small d-flex justify-content-between align-items-center gap-2 flex-wrap">
                                <div>
                                    <strong><?= e($payment['x_tipo_copia']) ?></strong>
                                    <span class="text-muted ms-2"><?= e($payment['x_codigo_pago']) ?></span>
                                    <div class="text-muted mt-1">
                                        Entrega: <?= e($payment['x_estado_entrega'] ?? 'PENDIENTE DE PREPARACION') ?>
                                        <?php if (!empty($payment['f_preparacion'])): ?>
                                            <span class="ms-2">Preparada: <?= date('d/m/Y H:i', strtotime($payment['f_preparacion'])) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <span class="badge bg-success">
                                        <?= e($payment['x_estado']) ?> | S/ <?= number_format((float) $payment['n_monto'], 2) ?>
                                    </span>
                                    <?php if ($copyReady): ?>
                                        <a href="<?= e($copyUrl) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-eye"></i> Ver copia
                                        </a>
                                        <a href="<?= e($copyUrl . '&download=1') ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-download"></i> Descargar
                                        </a>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">En preparacion</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h6 class="text-pj-blue fw-bold mb-4"><i class="bi bi-signpost-2-fill me-2"></i>Trazabilidad</h6>
                    <ul class="timeline small">
                        <?php foreach ($historial as $index => $h): ?>
                            <li class="timeline-item">
                                <div class="timeline-marker <?= $index === 0 ? 'active' : '' ?>"></div>
                                <div class="fw-bold text-pj-blue"><?= e($h['x_tipo_solicitud_estado']) ?></div>
                                <div class="text-muted fw-bold" style="font-size: 11px;"><?= e($h['x_corte']) ?></div>
                                <div class="text-secondary"><?= e($h['x_observacion']) ?></div>
                                <div class="text-muted" style="font-size: 10px;"><?= date('d/m/Y H:i', strtotime($h['f_registro'])) ?></div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<button type="button"
        class="btn btn-pj-blue rounded-circle shadow position-fixed d-flex align-items-center justify-content-center"
        style="right: 24px; bottom: 24px; width: 62px; height: 62px; z-index: 1040;"
        id="openVirtualAssistant"
        aria-label="Abrir asistente virtual">
    <i class="bi bi-chat-dots fs-3"></i>
</button>

<div id="virtualAssistantPanel"
     class="position-fixed bg-white border-0 shadow rounded-3 d-none"
     style="right: 24px; bottom: 92px; width: min(420px, calc(100vw - 32px)); max-height: calc(100vh - 120px); z-index: 1041; overflow: hidden;">
    <div class="bg-pj-blue text-white d-flex justify-content-between align-items-center px-3 py-3">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-headset me-2"></i>Chat con administrador
        </h5>
        <button type="button" class="btn btn-sm text-white border-0" id="closeVirtualAssistant" aria-label="Cerrar">
            <i class="bi bi-x-lg fs-5"></i>
        </button>
    </div>
    <div class="p-3" style="max-height: calc(100vh - 185px); overflow-y: auto;">
        <div class="small text-muted mb-3">
            Escribe tu consulta y Administracion del Sistema la atendera desde Soporte SLA.
        </div>
        <div id="chatTicketState" class="alert alert-light border small py-2 <?= empty($supportTicket) ? 'd-none' : '' ?>">
            Ticket SLA #<span id="chatTicketCode"><?= !empty($supportTicket) ? (int) $supportTicket['c_solicitud_apoyo'] : '' ?></span> -
            <strong id="chatTicketStatus"><?= !empty($supportTicket) ? e($supportTicket['x_estado']) : '' ?></strong>
        </div>
        <div id="citizenChatMessages" class="border rounded bg-light p-3 mb-3" style="height: 280px; overflow-y: auto;"></div>
        <form id="citizenChatForm" method="post" action="<?= url('/solicitudes/apoyo/mensaje') ?>">
            <input type="hidden" name="c_solicitud" value="<?= (int) $solicitud['c_solicitud'] ?>">
            <input type="hidden" name="accion" id="chatAction" value="">
            <label class="form-label fw-bold small">Mensaje</label>
            <textarea name="x_mensaje" id="chatMessage" class="form-control mb-2" rows="3" placeholder="Escribe cualquier consulta sobre tu solicitud o documento."></textarea>
            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-sm btn-pj-blue" id="sendCitizenMessage">
                    <i class="bi bi-send me-1"></i> Enviar consulta
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content" method="post" action="<?= url('/pagos/reproduccion') ?>">
            <div class="modal-header bg-pj-blue text-white">
                <h5 class="modal-title">
                    <i class="bi bi-credit-card me-2"></i>Culqi Online - Pago de reproduccion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="c_solicitud" value="<?= (int) $solicitud['c_solicitud'] ?>">
                <input type="hidden" name="c_solicitud_respuesta" id="paymentResponse">
                <div class="alert alert-info border-0">
                    El PDF digital firmado se mantiene disponible sin pago. Este pago demo es solo para copia fisica, certificada o envio.
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Documento</label>
                    <input type="text" class="form-control" id="paymentDocument" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Tipo de copia</label>
                    <select name="x_tipo_copia" class="form-select" required>
                        <option value="COPIA SIMPLE">Copia simple impresa - S/ 5.00</option>
                        <option value="COPIA CERTIFICADA">Copia certificada - S/ 15.00</option>
                        <option value="ENVIO A DOMICILIO">Envio a domicilio - S/ 10.00</option>
                    </select>
                </div>
                <div class="border rounded p-3 bg-light">
                    <div class="fw-bold text-pj-blue mb-2">Modo demo Culqi Online</div>
                    <div class="small text-muted">
                        En produccion aqui se abre Culqi Checkout v4, se tokeniza la tarjeta/Yape/PagoEfectivo y el backend confirma el cargo con las llaves reales del comercio.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-pj-blue">
                    <i class="bi bi-credit-card me-1"></i> Pagar con Culqi Online demo
                </button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="signedCitizenModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-pj-blue text-white">
                <h5 class="modal-title">
                    <i class="bi bi-file-earmark-check me-2"></i>Respuesta firmada
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="signedCitizenFrame" class="w-100 border-0" style="height: 78vh;" title="Respuesta firmada"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('signedCitizenModal')?.addEventListener('show.bs.modal', function (event) {
        const url = event.relatedTarget?.getAttribute('data-url') || 'about:blank';
        const separator = url.includes('?') ? '&' : '?';
        document.getElementById('signedCitizenFrame').src = url === 'about:blank' ? url : url + separator + 'v=' + Date.now();
    });

    document.getElementById('signedCitizenModal')?.addEventListener('hidden.bs.modal', function () {
        document.getElementById('signedCitizenFrame').src = 'about:blank';
    });

    document.getElementById('paymentModal')?.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        document.getElementById('paymentResponse').value = button?.getAttribute('data-respuesta') || '';
        document.getElementById('paymentDocument').value = button?.getAttribute('data-documento') || '';
    });
</script>

<div class="modal fade" id="supportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form class="modal-content" method="post" action="<?= url('/solicitudes/apoyo') ?>">
            <div class="modal-header bg-pj-blue text-white">
                <h5 class="modal-title">
                    <i class="bi bi-life-preserver me-2"></i>Registrar solicitud de apoyo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="c_solicitud" value="<?= (int) $solicitud['c_solicitud'] ?>">
                <input type="hidden" name="c_anexo" id="supportAnexo">
                <div class="mb-3">
                    <label class="form-label fw-bold">Documento</label>
                    <input type="text" class="form-control" id="supportArchivo" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Motivo</label>
                    <select name="x_motivo" class="form-select" required>
                        <option value="DOCUMENTO EQUIVOCADO">Documento equivocado</option>
                        <option value="ARCHIVO NO SUBIDO">Archivo no subido o no encontrado</option>
                        <option value="DOCUMENTO DANADO">Documento danado o no se puede abrir</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Descripcion</label>
                    <textarea name="x_descripcion" class="form-control" rows="3" placeholder="Explica brevemente el problema con el PDF."></textarea>
                </div>
                <div class="alert alert-info border-0 mb-0">
                    Administracion del Sistema revisara esta incidencia dentro del SLA para corregir el archivo o coordinar la subsanacion.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-pj-blue">Registrar apoyo</button>
            </div>
        </form>
    </div>
</div>

<script>
    const citizenSolicitudId = <?= (int) $solicitud['c_solicitud'] ?>;
    const citizenMessagesUrl = '<?= url('/solicitudes/apoyo/mensajes') ?>';
    const citizenSendUrl = '<?= url('/solicitudes/apoyo/mensaje') ?>';
    let citizenChatTimer = null;

    function escapeChatHtml(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function renderCitizenChat(messages) {
        const box = document.getElementById('citizenChatMessages');
        if (!box) {
            return;
        }

        if (!messages || messages.length === 0) {
            box.innerHTML = '<div class="text-center text-muted small py-4">Aun no hay mensajes. Escribe tu consulta para iniciar el chat con Administracion del Sistema.</div>';
            return;
        }

        box.innerHTML = messages.map((message) => {
            const isCitizen = message.x_origen === 'CIUDADANO';
            const isBot = message.x_origen === 'BOT';
            const align = isCitizen ? 'justify-content-end' : '';
            const bubble = isCitizen ? 'bg-pj-blue text-white' : (isBot ? 'bg-info-subtle border' : 'bg-white border');
            const label = message.x_origen === 'ADMIN' ? 'ADMINISTRADOR' : message.x_origen;
            const date = message.f_registro ? new Date(String(message.f_registro).replace(' ', 'T')).toLocaleString('es-PE') : '';
            return `
                <div class="d-flex ${align} mb-2">
                    <div class="${bubble} rounded p-2 small" style="max-width: 84%;">
                        <div class="fw-bold mb-1">${escapeChatHtml(label)}</div>
                        <div>${escapeChatHtml(message.x_mensaje).replaceAll('\\n', '<br>')}</div>
                        <div class="${isCitizen ? 'text-white-50' : 'text-muted'}" style="font-size: 10px;">${escapeChatHtml(date)}</div>
                    </div>
                </div>
            `;
        }).join('');
        box.scrollTop = box.scrollHeight;
    }

    function renderCitizenTicket(ticket) {
        const state = document.getElementById('chatTicketState');
        if (!state) {
            return;
        }

        if (!ticket) {
            state.classList.add('d-none');
            return;
        }

        document.getElementById('chatTicketCode').textContent = ticket.c_solicitud_apoyo || '';
        document.getElementById('chatTicketStatus').textContent = ticket.x_estado || '';
        state.classList.remove('d-none');
    }

    async function loadCitizenChat() {
        try {
            const response = await fetch(`${citizenMessagesUrl}?solicitud=${encodeURIComponent(citizenSolicitudId)}`, {
                headers: {'Accept': 'application/json'}
            });
            const data = await response.json();
            if (data.ok) {
                renderCitizenTicket(data.ticket);
                renderCitizenChat(data.messages);
            }
        } catch (error) {
            console.warn('No se pudo actualizar el chat ciudadano.', error);
        }
    }

    document.getElementById('openVirtualAssistant')?.addEventListener('click', function () {
        const panel = document.getElementById('virtualAssistantPanel');
        panel?.classList.toggle('d-none');
        document.getElementById('chatMessage')?.focus();
        loadCitizenChat();
        clearInterval(citizenChatTimer);
        if (panel && !panel.classList.contains('d-none')) {
            citizenChatTimer = setInterval(loadCitizenChat, 4000);
        }
    });

    document.getElementById('closeVirtualAssistant')?.addEventListener('click', function () {
        document.getElementById('virtualAssistantPanel')?.classList.add('d-none');
        clearInterval(citizenChatTimer);
        citizenChatTimer = null;
    });

    document.getElementById('supportModal')?.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        document.getElementById('supportAnexo').value = button?.getAttribute('data-anexo') || '';
        document.getElementById('supportArchivo').value = button?.getAttribute('data-archivo') || '';
    });

    document.getElementById('citizenChatForm')?.addEventListener('submit', async function (event) {
        event.preventDefault();
        const message = document.getElementById('chatMessage');
        const sendButton = document.getElementById('sendCitizenMessage');
        const text = message.value.trim();
        if (text === '') {
            message.focus();
            return;
        }

        const body = new URLSearchParams();
        body.set('c_solicitud', String(citizenSolicitudId));
        body.set('x_mensaje', text);

        sendButton.disabled = true;
        try {
            const response = await fetch(citizenSendUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body
            });
            const data = await response.json();
            if (data.ok) {
                message.value = '';
                renderCitizenTicket(data.ticket);
                renderCitizenChat(data.messages);
            }
        } finally {
            sendButton.disabled = false;
            message.focus();
        }
    });
</script>
<?php $content = ob_get_clean(); require dirname(__DIR__) . '/layouts/app.php'; ?>
