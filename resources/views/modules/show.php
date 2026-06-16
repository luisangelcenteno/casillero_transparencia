<?php
$title = $module['titulo'];
$canAssistantSign = in_array($slug ?? '', ['actualizar-estados', 'adjuntar-documentos'], true);
$canMesaPartes = in_array($slug ?? '', ['validar-ingresos', 'remitir-solicitudes'], true);
$canArchivo = in_array($slug ?? '', ['busqueda-documental', 'preparar-anexos'], true);
$canBossUploadSignature = ($slug ?? '') === 'supervision';
$visibleColumns = !empty($rows)
    ? array_values(array_filter(array_keys($rows[0]), fn ($column) => !str_starts_with((string) $column, '_')))
    : [];
$signedVisibleColumns = !empty($signedRows ?? [])
    ? array_values(array_filter(array_keys($signedRows[0]), fn ($column) => !str_starts_with((string) $column, '_')))
    : [];
ob_start();
?>
<div class="container-fluid dashboard-page">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <span class="badge bg-pj-gold text-pj-blue mb-2"><?= e($module['seccion']) ?></span>
            <h4 class="text-pj-blue fw-bold mb-1">
                <i class="bi <?= e($module['icono']) ?> me-2"></i><?= e($module['titulo']) ?>
            </h4>
            <p class="text-muted small mb-0"><?= e($module['descripcion']) ?></p>
        </div>
        <a href="<?= url('/dashboard') ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <?php if (old_query('msg') === 'firmado'): ?>
        <div class="alert alert-success border-0 shadow-sm">
            <i class="bi bi-check-circle me-2"></i>
            Respuesta firmada registrada. Ahora aparece en Documentos firmados y la solicitud paso a ATENDIDO.
        </div>
    <?php elseif (old_query('error') === 'firma'): ?>
        <div class="alert alert-danger border-0 shadow-sm">
            <i class="bi bi-exclamation-triangle me-2"></i>
            No se pudo registrar la firma. Verifica que la solicitud exista y vuelva a intentarlo.
        </div>
    <?php elseif (old_query('error') === 'firma_jefe'): ?>
        <div class="alert alert-warning border-0 shadow-sm">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Selecciona una firma de jefatura activa para la misma corte de la solicitud.
        </div>
    <?php elseif (old_query('msg') === 'firma_jefatura'): ?>
        <div class="alert alert-success border-0 shadow-sm">
            <i class="bi bi-check-circle me-2"></i>
            Firma de jefatura registrada. Asistencia ya puede seleccionarla al firmar una respuesta.
        </div>
    <?php elseif (old_query('msg') === 'firma_actualizada'): ?>
        <div class="alert alert-success border-0 shadow-sm">
            <i class="bi bi-check-circle me-2"></i>
            Firma de jefatura actualizada correctamente.
        </div>
    <?php elseif (old_query('msg') === 'firma_eliminada'): ?>
        <div class="alert alert-secondary border-0 shadow-sm">
            <i class="bi bi-trash me-2"></i>
            Firma de jefatura eliminada. Ya no aparecera para Asistencia.
        </div>
    <?php elseif (old_query('error') === 'firma_jefatura'): ?>
        <div class="alert alert-danger border-0 shadow-sm">
            <i class="bi bi-exclamation-triangle me-2"></i>
            No se pudo registrar la firma. Completa corte, nombre del juez y archivo de firma.
        </div>
    <?php elseif (old_query('msg') === 'estado'): ?>
        <div class="alert alert-success border-0 shadow-sm">
            <i class="bi bi-check-circle me-2"></i>
            Estado de soporte SLA actualizado correctamente.
        </div>
    <?php elseif (old_query('msg') === 'chat'): ?>
        <div class="alert alert-success border-0 shadow-sm">
            <i class="bi bi-chat-dots me-2"></i>
            Mensaje enviado al ciudadano desde Soporte SLA.
        </div>
    <?php elseif (old_query('msg') === 'copia_preparada'): ?>
        <div class="alert alert-success border-0 shadow-sm">
            <i class="bi bi-file-earmark-check me-2"></i>
            Copia preparada con marca de agua. El ciudadano ya puede verla y descargarla.
        </div>
    <?php elseif (old_query('msg') === 'copia_entregada'): ?>
        <div class="alert alert-success border-0 shadow-sm">
            <i class="bi bi-check2-circle me-2"></i>
            Copia marcada como entregada correctamente.
        </div>
    <?php elseif (old_query('error') === 'estado'): ?>
        <div class="alert alert-danger border-0 shadow-sm">
            <i class="bi bi-exclamation-triangle me-2"></i>
            No se pudo actualizar el estado del soporte.
        </div>
    <?php elseif (str_starts_with((string) old_query('error'), 'copia')): ?>
        <div class="alert alert-danger border-0 shadow-sm">
            <i class="bi bi-exclamation-triangle me-2"></i>
            No se pudo preparar o entregar la copia. Verifica que el PDF firmado exista en storage/uploads.
        </div>
    <?php endif; ?>

    <?php if (($slug ?? '') === 'reportes'): ?>
        <div class="row g-3 mb-4">
            <?php foreach (($reportStats ?? []) as $label => $value): ?>
                <div class="col-md-4 col-xl-2">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="small fw-bold text-muted mb-2"><?= e($label) ?></div>
                            <div class="h3 fw-bold text-pj-blue mb-0"><?= (int) $value ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-pj-blue">
                            <i class="bi bi-clipboard-data me-2"></i>Seguimiento de solicitudes
                        </h6>
                    </div>
                    <div class="card-body">
                        <?php if (empty($reportRows ?? [])): ?>
                            <div class="text-center text-muted py-4">No hay solicitudes para reportar.</div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <?php foreach (array_keys($reportRows[0]) as $column): ?>
                                                <th><?= e($column) ?></th>
                                            <?php endforeach; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($reportRows as $row): ?>
                                            <tr>
                                                <?php foreach ($row as $value): ?>
                                                    <td class="small"><?= e((string) $value) ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-pj-blue">
                            <i class="bi bi-life-preserver me-2"></i>Soporte SLA
                        </h6>
                    </div>
                    <div class="card-body">
                        <?php if (empty($supportRows ?? [])): ?>
                            <div class="text-center text-muted py-4">No hay incidencias de soporte.</div>
                        <?php else: ?>
                            <div class="d-grid gap-2">
                                <?php foreach (array_slice($supportRows, 0, 5) as $support): ?>
                                    <div class="border rounded p-2">
                                        <div class="d-flex justify-content-between gap-2">
                                            <strong class="small text-pj-blue">Solicitud #<?= e((string) $support['Solicitud']) ?></strong>
                                            <span class="badge <?= ($support['SLA'] ?? '') === 'VENCIDO' ? 'bg-danger' : 'bg-success' ?>"><?= e($support['SLA'] ?? '') ?></span>
                                        </div>
                                        <div class="small text-muted"><?= e($support['Motivo'] ?? '') ?></div>
                                        <div class="small"><?= e($support['Documento'] ?? '') ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($canBossUploadSignature): ?>
        <div class="row g-3 mb-4">
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-pj-blue">
                            <i class="bi bi-pen me-2"></i>Registrar firma digital
                        </h6>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= url('/modulos/subir-firma-jefatura') ?>" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Corte</label>
                                <select name="c_corte" class="form-select" required>
                                    <option value="">Seleccionar corte</option>
                                    <?php foreach (($cortes ?? []) as $corte): ?>
                                        <option value="<?= e($corte['c_corte']) ?>"><?= e($corte['x_corte']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre del juez</label>
                                <input type="text" name="x_juez" class="form-control" placeholder="Ej. Juan Perez Ramirez" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Cargo</label>
                                <input type="text" name="x_cargo" class="form-control" value="Juez Superior" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Archivo de firma</label>
                                <input type="file" name="firma" class="form-control" accept=".png,.jpg,.jpeg,.pdf" required>
                            </div>
                            <button class="btn btn-pj-blue w-100" type="submit">
                                <i class="bi bi-cloud-arrow-up me-1"></i> Guardar firma
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-pj-blue">
                            <i class="bi bi-person-lines-fill me-2"></i>Firmas disponibles
                        </h6>
                    </div>
                    <div class="card-body">
                        <?php if (empty($firmasJefes ?? [])): ?>
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-file-earmark-lock fs-2 d-block mb-2"></i>
                                Aun no hay firmas registradas por jefatura.
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Juez</th>
                                            <th>Corte</th>
                                            <th>Cargo</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($firmasJefes as $firma): ?>
                                            <?php $canManageSignature = ($_SESSION['id_perfil'] ?? '') === '10' || (int) ($firma['c_usuario'] ?? 0) === (int) ($_SESSION['id_usuario'] ?? 0); ?>
                                            <tr>
                                                <td class="small fw-bold"><?= e($firma['x_juez']) ?></td>
                                                <td class="small"><?= e($firma['x_corte']) ?></td>
                                                <td class="small"><?= e($firma['x_cargo']) ?></td>
                                                <td class="text-end text-nowrap">
                                                    <?php $firmaUrl = url('/firmas/jefatura?id=' . (int) $firma['c_firma_jefe']); ?>
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-secondary"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#viewSignatureModal"
                                                            data-url="<?= e($firmaUrl) ?>"
                                                            data-pdf="<?= strtolower(pathinfo($firma['x_archivo'], PATHINFO_EXTENSION)) === 'pdf' ? '1' : '0' ?>"
                                                            data-juez="<?= e($firma['x_juez']) ?>"
                                                            data-corte="<?= e($firma['x_corte']) ?>"
                                                            data-cargo="<?= e($firma['x_cargo']) ?>">
                                                        <i class="bi bi-eye"></i> Ver
                                                    </button>
                                                    <?php if ($canManageSignature): ?>
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editSignatureModal"
                                                                data-id="<?= (int) $firma['c_firma_jefe'] ?>"
                                                                data-corte="<?= e($firma['c_corte']) ?>"
                                                                data-juez="<?= e($firma['x_juez']) ?>"
                                                                data-cargo="<?= e($firma['x_cargo']) ?>">
                                                            <i class="bi bi-pencil"></i> Editar
                                                        </button>
                                                        <form method="post" action="<?= url('/modulos/eliminar-firma-jefatura') ?>" class="d-inline" onsubmit="return confirm('Seguro que deseas eliminar esta firma?');">
                                                            <input type="hidden" name="c_firma_jefe" value="<?= (int) $firma['c_firma_jefe'] ?>">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="bi bi-trash"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (($slug ?? '') === 'adjuntar-documentos'): ?>
        <div class="row g-3 mb-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-pj-blue">
                            <i class="bi bi-file-earmark-text me-2"></i>Plantillas de respuesta
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="fw-bold text-pj-blue mb-1">Respuesta al ciudadano</div>
                                    <div class="small text-muted mb-3">Formato principal para remitir informacion o anexos.</div>
                                    <a class="btn btn-sm btn-pj-blue w-100" href="<?= url('/plantillas/descargar?tipo=respuesta') ?>">
                                        <i class="bi bi-download me-1"></i> Descargar
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="fw-bold text-pj-blue mb-1">Informe de atencion</div>
                                    <div class="small text-muted mb-3">Sustento interno del analisis y documentos ubicados.</div>
                                    <a class="btn btn-sm btn-outline-secondary w-100" href="<?= url('/plantillas/descargar?tipo=informe') ?>">
                                        <i class="bi bi-download me-1"></i> Descargar
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="fw-bold text-pj-blue mb-1">Observacion</div>
                                    <div class="small text-muted mb-3">Para subsanar documento faltante, errado o danado.</div>
                                    <a class="btn btn-sm btn-outline-secondary w-100" href="<?= url('/plantillas/descargar?tipo=observacion') ?>">
                                        <i class="bi bi-download me-1"></i> Descargar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold text-pj-blue">
                            <i class="bi bi-ui-checks-grid me-2"></i>Checklist antes de firmar
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2 small">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-check-circle text-success"></i>
                                <span>Validar que el PDF del ciudadano abra correctamente.</span>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-check-circle text-success"></i>
                                <span>Adjuntar respuesta, informe o anexos generados por el area competente.</span>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-check-circle text-success"></i>
                                <span>Seleccionar la firma de jefatura correspondiente a la misma corte.</span>
                            </div>
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi bi-exclamation-triangle text-warning"></i>
                                <span>Si el documento esta errado o no existe en carpeta, registrar soporte SLA.</span>
                            </div>
                        </div>
                        <hr>
                        <div class="small text-muted">
                            Despues de confirmar firma, el sistema genera el PDF firmado y lo publica en Respuestas para el ciudadano.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="modal fade" id="editSignatureModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form class="modal-content" method="post" action="<?= url('/modulos/actualizar-firma-jefatura') ?>" enctype="multipart/form-data">
                <div class="modal-header bg-pj-blue text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil me-2"></i>Editar firma digital
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="c_firma_jefe" id="editFirmaId">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Corte</label>
                            <select name="c_corte" class="form-select" id="editFirmaCorte" required>
                                <?php foreach (($cortes ?? []) as $corte): ?>
                                    <option value="<?= e($corte['c_corte']) ?>"><?= e($corte['x_corte']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label fw-bold">Nombre del juez</label>
                            <input type="text" name="x_juez" class="form-control" id="editFirmaJuez" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Cargo</label>
                            <input type="text" name="x_cargo" class="form-control" id="editFirmaCargo" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Cambiar archivo de firma</label>
                            <input type="file" name="firma" class="form-control" accept=".png,.jpg,.jpeg,.pdf">
                            <div class="form-text">Dejalo vacio si solo quieres cambiar datos del juez, cargo o corte.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-pj-blue">
                        <i class="bi bi-check2-circle me-1"></i> Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('editSignatureModal')?.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            document.getElementById('editFirmaId').value = button?.getAttribute('data-id') || '';
            document.getElementById('editFirmaCorte').value = button?.getAttribute('data-corte') || '';
            document.getElementById('editFirmaJuez').value = button?.getAttribute('data-juez') || '';
            document.getElementById('editFirmaCargo').value = button?.getAttribute('data-cargo') || '';
        });
    </script>

    <div class="modal fade" id="viewSignatureModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-pj-blue text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-eye me-2"></i>Vista previa de firma
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="fw-bold text-pj-blue" id="viewFirmaJuez"></div>
                        <div class="small text-muted" id="viewFirmaDetalle"></div>
                    </div>
                    <div class="border rounded bg-light p-3 text-center">
                        <img id="viewFirmaImage" class="img-fluid d-none" style="max-height: 360px;" alt="Firma de jefatura">
                        <iframe id="viewFirmaFrame" class="w-100 border-0 d-none bg-white" style="height: 460px;" title="Firma de jefatura"></iframe>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('viewSignatureModal')?.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const url = button?.getAttribute('data-url') || '';
            const isPdf = button?.getAttribute('data-pdf') === '1';
            const juez = button?.getAttribute('data-juez') || '';
            const corte = button?.getAttribute('data-corte') || '';
            const cargo = button?.getAttribute('data-cargo') || '';
            const image = document.getElementById('viewFirmaImage');
            const frame = document.getElementById('viewFirmaFrame');

            document.getElementById('viewFirmaJuez').textContent = juez;
            document.getElementById('viewFirmaDetalle').textContent = cargo + ' - ' + corte;

            image.classList.add('d-none');
            frame.classList.add('d-none');
            image.src = '';
            frame.src = 'about:blank';

            if (isPdf) {
                frame.src = url;
                frame.classList.remove('d-none');
                return;
            }

            image.src = url;
            image.classList.remove('d-none');
        });
    </script>

    <?php if ($canArchivo): ?>
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-pj-blue">
                    <i class="bi bi-archive me-2"></i>Solicitudes derivadas a Archivo Central
                </h6>
            </div>
            <div class="card-body">
                <?php if (empty($rows)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        No hay registros para mostrar en este modulo.
                    </div>
                <?php else: ?>
                    <div class="d-grid gap-3">
                        <?php foreach ($rows as $row): ?>
                            <?php
                                $archivoAnexos = [];
                                foreach (explode('||', (string) ($row['_Anexos'] ?? '')) as $item) {
                                    if ($item === '' || !str_contains($item, '::')) {
                                        continue;
                                    }

                                    [$id, $name] = explode('::', $item, 2);
                                    $archivoAnexos[] = [
                                        'id' => (int) $id,
                                        'name' => $name,
                                        'url' => url('/documentos/anexo?id=' . (int) $id),
                                    ];
                                }

                                $firstArchivoAnexo = $archivoAnexos[0] ?? null;
                            ?>
                            <div class="border rounded p-3 bg-white">
                                <div class="d-flex flex-wrap justify-content-between gap-3">
                                    <div style="min-width: 260px; max-width: 620px;">
                                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                            <span class="badge bg-pj-blue">Solicitud #<?= e((string) ($row['Solicitud'] ?? '')) ?></span>
                                            <span class="badge bg-light text-pj-blue border"><?= e((string) ($row['Estado'] ?? '')) ?></span>
                                        </div>
                                        <div class="fw-bold text-pj-blue"><?= e((string) ($row['Ciudadano'] ?? '')) ?></div>
                                        <div class="small text-muted mb-2"><?= e((string) ($row['Corte'] ?? '')) ?> | <?= e((string) ($row['Fecha'] ?? '')) ?></div>
                                        <div class="small text-secondary" style="max-width: 760px;">
                                            <?= e((string) ($row['Derivacion'] ?? '')) ?>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column gap-2" style="min-width: 230px;">
                                        <a href="<?= url('/solicitudes/detalle?id=' . (int) ($row['Solicitud'] ?? 0)) ?>" class="btn btn-sm btn-pj-blue text-start">
                                            <i class="bi bi-eye me-1"></i> Ver solicitud
                                        </a>
                                        <?php if ($firstArchivoAnexo): ?>
                                            <a href="<?= e($firstArchivoAnexo['url']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary text-start">
                                                <i class="bi bi-file-earmark me-1"></i> Ver documento
                                            </a>
                                        <?php endif; ?>
                                        <?php if (($slug ?? '') === 'busqueda-documental'): ?>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-success text-start"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#archiveLocationModal"
                                                    data-solicitud="<?= e((string) ($row['Solicitud'] ?? '')) ?>"
                                                    data-ciudadano="<?= e((string) ($row['Ciudadano'] ?? '')) ?>"
                                                    data-corte="<?= e((string) ($row['_CorteCodigo'] ?? '')) ?>">
                                                <i class="bi bi-geo-alt me-1"></i> Registrar ubicacion
                                            </button>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-warning text-start"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#archiveNotFoundModal"
                                                    data-solicitud="<?= e((string) ($row['Solicitud'] ?? '')) ?>"
                                                    data-corte="<?= e((string) ($row['_CorteCodigo'] ?? '')) ?>">
                                                <i class="bi bi-search me-1"></i> No ubicado
                                            </button>
                                            <a href="<?= url('/modulos/preparar-anexos') ?>" class="btn btn-sm btn-outline-primary text-start">
                                                <i class="bi bi-folder-check me-1"></i> Preparar anexos
                                            </a>
                                        <?php else: ?>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-success text-start"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#archivePrepareModal"
                                                    data-solicitud="<?= e((string) ($row['Solicitud'] ?? '')) ?>"
                                                    data-ciudadano="<?= e((string) ($row['Ciudadano'] ?? '')) ?>"
                                                    data-corte="<?= e((string) ($row['_CorteCodigo'] ?? '')) ?>">
                                                <i class="bi bi-paperclip me-1"></i> Adjuntar documento
                                            </button>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-primary text-start"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#archiveRemitModal"
                                                    data-solicitud="<?= e((string) ($row['Solicitud'] ?? '')) ?>"
                                                    data-ciudadano="<?= e((string) ($row['Ciudadano'] ?? '')) ?>"
                                                    data-corte="<?= e((string) ($row['_CorteCodigo'] ?? '')) ?>">
                                                <i class="bi bi-send me-1"></i> Remitir resultado
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (($slug ?? '') !== 'reportes' && !$canArchivo): ?>
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold text-pj-blue">
                <?php if (($slug ?? '') === 'soporte-sla'): ?>
                    Solicitudes pendientes de soporte
                <?php elseif (($slug ?? '') === 'pagos-culqi'): ?>
                    Pagos registrados por reproduccion
                <?php elseif (($slug ?? '') === 'auditoria-sistema'): ?>
                    Ultimos registros de auditoria del sistema
                <?php elseif ($canMesaPartes): ?>
                    Solicitudes pendientes de validacion y remision
                <?php elseif ($canArchivo): ?>
                    Solicitudes derivadas a Archivo Central
                <?php else: ?>
                    Solicitudes pendientes de firma
                <?php endif; ?>
            </h6>
        </div>
        <div class="card-body">
            <?php if (empty($rows)): ?>
                <div class="text-center text-muted py-5">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    No hay registros para mostrar en este modulo.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <?php foreach ($visibleColumns as $column): ?>
                                    <th><?= e((string) $column) ?></th>
                                <?php endforeach; ?>
                                <?php if ($canAssistantSign || $canMesaPartes || $canArchivo || in_array(($slug ?? ''), ['soporte-sla', 'pagos-culqi'], true)): ?>
                                    <th class="text-end">Acciones</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <?php foreach ($visibleColumns as $column): ?>
                                        <td class="small"><?= e((string) ($row[$column] ?? '')) ?></td>
                                    <?php endforeach; ?>
                                    <?php if (($slug ?? '') === 'soporte-sla'): ?>
                                        <td class="text-end text-nowrap">
                                            <button type="button"
                                                    class="btn btn-sm btn-pj-blue support-action"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#supportStatusModal"
                                                    data-codigo="<?= e((string) ($row['Codigo'] ?? '')) ?>"
                                                    data-solicitud="<?= e((string) ($row['Solicitud'] ?? '')) ?>"
                                                    data-documento="<?= e((string) ($row['Documento'] ?? '')) ?>"
                                                    data-motivo="<?= e((string) ($row['Motivo'] ?? '')) ?>"
                                                    data-estado="<?= e((string) ($row['Estado'] ?? '')) ?>"
                                                    data-descripcion="<?= e((string) ($row['_Descripcion'] ?? '')) ?>"
                                                    data-mensajes="<?= e((string) ($row['_Mensajes'] ?? '')) ?>">
                                                <i class="bi bi-chat-dots"></i> Chat
                                            </button>
                                        </td>
                                    <?php elseif (($slug ?? '') === 'pagos-culqi'): ?>
                                        <?php
                                            $paymentId = (int) ($row['_PagoId'] ?? $row['Codigo'] ?? 0);
                                            $deliveryState = (string) ($row['Entrega'] ?? '');
                                            $hasCopy = trim((string) ($row['Copia'] ?? '')) !== '';
                                            $copyUrl = url('/documentos/copia-pagada?id=' . $paymentId);
                                        ?>
                                        <td class="text-end">
                                            <div class="d-flex flex-wrap justify-content-end gap-2">
                                                <?php if (!$hasCopy): ?>
                                                    <form method="post" action="<?= url('/modulos/pagos-culqi/preparar') ?>" class="d-inline">
                                                        <input type="hidden" name="c_pago_reproduccion" value="<?= $paymentId ?>">
                                                        <button type="submit" class="btn btn-sm btn-pj-blue">
                                                            <i class="bi bi-file-earmark-plus"></i> Preparar copia
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <a href="<?= e($copyUrl) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary">
                                                        <i class="bi bi-eye"></i> Ver copia
                                                    </a>
                                                    <a href="<?= e($copyUrl . '&download=1') ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-download"></i> Descargar
                                                    </a>
                                                    <?php if ($deliveryState !== 'ENTREGADO'): ?>
                                                        <form method="post" action="<?= url('/modulos/pagos-culqi/entregar') ?>" class="d-inline">
                                                            <input type="hidden" name="c_pago_reproduccion" value="<?= $paymentId ?>">
                                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                                <i class="bi bi-check2-circle"></i> Entregar
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    <?php elseif ($canArchivo): ?>
                                        <?php
                                            $archivoAnexos = [];
                                            foreach (explode('||', (string) ($row['_Anexos'] ?? '')) as $item) {
                                                if ($item === '' || !str_contains($item, '::')) {
                                                    continue;
                                                }

                                                [$id, $name] = explode('::', $item, 2);
                                                $archivoAnexos[] = [
                                                    'id' => (int) $id,
                                                    'name' => $name,
                                                    'url' => url('/documentos/anexo?id=' . (int) $id),
                                                ];
                                            }

                                            $firstArchivoAnexo = $archivoAnexos[0] ?? null;
                                        ?>
                                        <td class="text-end text-nowrap">
                                            <a href="<?= url('/solicitudes/detalle?id=' . (int) ($row['Solicitud'] ?? 0)) ?>" class="btn btn-sm btn-pj-blue">
                                                <i class="bi bi-eye"></i> Ver solicitud
                                            </a>
                                            <?php if ($firstArchivoAnexo): ?>
                                                <a href="<?= e($firstArchivoAnexo['url']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-file-earmark"></i> Ver documento
                                                </a>
                                            <?php endif; ?>
                                            <?php if (($slug ?? '') === 'busqueda-documental'): ?>
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#archiveLocationModal"
                                                        data-solicitud="<?= e((string) ($row['Solicitud'] ?? '')) ?>"
                                                        data-ciudadano="<?= e((string) ($row['Ciudadano'] ?? '')) ?>"
                                                        data-corte="<?= e((string) ($row['_CorteCodigo'] ?? '')) ?>">
                                                    <i class="bi bi-geo-alt"></i> Registrar ubicacion
                                                </button>
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#archiveNotFoundModal"
                                                        data-solicitud="<?= e((string) ($row['Solicitud'] ?? '')) ?>"
                                                        data-corte="<?= e((string) ($row['_CorteCodigo'] ?? '')) ?>">
                                                    <i class="bi bi-search"></i> No ubicado
                                                </button>
                                            <?php endif; ?>
                                            <?php if (($slug ?? '') === 'preparar-anexos'): ?>
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#archivePrepareModal"
                                                        data-solicitud="<?= e((string) ($row['Solicitud'] ?? '')) ?>"
                                                        data-ciudadano="<?= e((string) ($row['Ciudadano'] ?? '')) ?>"
                                                        data-corte="<?= e((string) ($row['_CorteCodigo'] ?? '')) ?>">
                                                    <i class="bi bi-paperclip"></i> Adjuntar documento
                                                </button>
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#archiveRemitModal"
                                                        data-solicitud="<?= e((string) ($row['Solicitud'] ?? '')) ?>"
                                                        data-ciudadano="<?= e((string) ($row['Ciudadano'] ?? '')) ?>"
                                                        data-corte="<?= e((string) ($row['_CorteCodigo'] ?? '')) ?>">
                                                    <i class="bi bi-send"></i> Remitir resultado
                                                </button>
                                            <?php else: ?>
                                                <a href="<?= url('/modulos/preparar-anexos') ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-folder-check"></i> Preparar anexos
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    <?php elseif ($canMesaPartes): ?>
                                        <?php
                                            $mesaAnexos = [];
                                            foreach (explode('||', (string) ($row['_Anexos'] ?? '')) as $item) {
                                                if ($item === '' || !str_contains($item, '::')) {
                                                    continue;
                                                }

                                                [$id, $name] = explode('::', $item, 2);
                                                $mesaAnexos[] = [
                                                    'id' => (int) $id,
                                                    'name' => $name,
                                                    'url' => url('/documentos/anexo?id=' . (int) $id),
                                                ];
                                            }

                                            $firstAnexo = $mesaAnexos[0] ?? null;
                                            $alreadyValidatedByMesa = str_starts_with(
                                                mb_strtoupper((string) ($row['Derivacion'] ?? ''), 'UTF-8'),
                                                'VALIDADO POR MESA DE PARTES'
                                            );
                                        ?>
                                        <td class="text-end text-nowrap">
                                            <a href="<?= url('/solicitudes/detalle?id=' . (int) ($row['Solicitud'] ?? 0)) ?>" class="btn btn-sm btn-pj-blue">
                                                <i class="bi bi-eye"></i> Ver solicitud
                                            </a>
                                            <?php if ($firstAnexo): ?>
                                                <a href="<?= e($firstAnexo['url']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-file-earmark"></i> Ver documento
                                                </a>
                                            <?php endif; ?>
                                            <?php if (($slug ?? '') === 'validar-ingresos'): ?>
                                                <form method="post" action="<?= url('/modulos/mesa-partes/validar') ?>" class="d-inline">
                                                    <input type="hidden" name="c_solicitud" value="<?= (int) ($row['Solicitud'] ?? 0) ?>">
                                                    <input type="hidden" name="c_corte" value="<?= e((string) ($row['_CorteCodigo'] ?? '')) ?>">
                                                    <button type="submit" class="btn btn-sm btn-outline-success" <?= $alreadyValidatedByMesa ? 'disabled' : '' ?>>
                                                        <i class="bi bi-check2-circle"></i> Validar ingreso
                                                    </button>
                                                </form>
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#observeMesaModal"
                                                        data-solicitud="<?= e((string) ($row['Solicitud'] ?? '')) ?>"
                                                        data-corte="<?= e((string) ($row['_CorteCodigo'] ?? '')) ?>">
                                                    <i class="bi bi-exclamation-circle"></i> Observar
                                                </button>
                                            <?php endif; ?>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#remitMesaModal"
                                                    data-solicitud="<?= e((string) ($row['Solicitud'] ?? '')) ?>"
                                                    data-ciudadano="<?= e((string) ($row['Ciudadano'] ?? '')) ?>"
                                                    data-corte="<?= e((string) ($row['_CorteCodigo'] ?? '')) ?>">
                                                <i class="bi bi-send"></i> Remitir
                                            </button>
                                        </td>
                                    <?php elseif ($canAssistantSign): ?>
                                        <?php
                                            $anexos = [];
                                            foreach (explode('||', (string) ($row['_Anexos'] ?? '')) as $item) {
                                                if ($item === '' || !str_contains($item, '::')) {
                                                    continue;
                                                }

                                                [$id, $name] = explode('::', $item, 2);
                                                $anexos[] = [
                                                    'id' => (int) $id,
                                                    'name' => $name,
                                                    'url' => url('/documentos/anexo?id=' . (int) $id),
                                                    'isPdf' => strtolower(pathinfo($name, PATHINFO_EXTENSION)) === 'pdf',
                                                ];
                                            }

                                            $firmasParaSolicitud = [];
                                            foreach (($firmasJefes ?? []) as $firma) {
                                                $compatible = (string) $firma['c_corte'] === (string) ($row['_CorteCodigo'] ?? '');
                                                $firmasParaSolicitud[] = [
                                                    'id' => (int) $firma['c_firma_jefe'],
                                                    'juez' => $firma['x_juez'],
                                                    'cargo' => $firma['x_cargo'],
                                                    'corte' => $firma['x_corte'],
                                                    'compatible' => $compatible,
                                                    'archivo' => $firma['x_archivo'],
                                                    'url' => url('/firmas/jefatura?id=' . (int) $firma['c_firma_jefe']),
                                                    'isPdf' => strtolower(pathinfo($firma['x_archivo'], PATHINFO_EXTENSION)) === 'pdf',
                                                ];
                                            }
                                        ?>
                                        <td class="text-end text-nowrap">
                                            <a href="<?= url('/solicitudes/detalle?id=' . (int) ($row['Solicitud'] ?? 0)) ?>" class="btn btn-sm btn-pj-blue">
                                                <i class="bi bi-eye"></i> Ver solicitud
                                            </a>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#signResponseModal"
                                                    data-solicitud="<?= e((string) ($row['Solicitud'] ?? '')) ?>"
                                                    data-ciudadano="<?= e((string) ($row['Ciudadano'] ?? '')) ?>"
                                                    data-corte="<?= e((string) ($row['Corte'] ?? '')) ?>"
                                                    data-anexos='<?= e(json_encode($anexos, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES)) ?>'
                                                    data-firmas='<?= e(json_encode($firmasParaSolicitud, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES)) ?>'>
                                                <i class="bi bi-pen"></i> Firmar respuesta
                                            </button>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
    </div>
    <?php endif; ?>

    <?php if (($slug ?? '') === 'soporte-sla'): ?>
        <div class="modal fade" id="supportStatusModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <form class="modal-content" method="post" action="<?= url('/modulos/soporte-sla/estado') ?>">
                    <div class="modal-header bg-pj-blue text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-life-preserver me-2"></i>Atender soporte SLA
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="c_solicitud_apoyo" id="supportCode">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Solicitud</label>
                                <input type="text" class="form-control" id="supportRequest" readonly>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Documento</label>
                                <input type="text" class="form-control" id="supportDocument" readonly>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Motivo</label>
                                <input type="text" class="form-control" id="supportReason" readonly>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold">Nuevo estado</label>
                                <select name="x_estado" class="form-select" id="supportState" required>
                                    <option value="PENDIENTE">Pendiente</option>
                                    <option value="EN ATENCION">En atencion</option>
                                    <option value="RESUELTO">Resuelto</option>
                                    <option value="CERRADO">Cerrado</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Observacion administrativa</label>
                                <textarea name="x_observacion" class="form-control" rows="3" placeholder="Ej. Se coordino con el ciudadano y se habilito nueva carga de documento."></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Historial / descripcion</label>
                                <textarea class="form-control" id="supportDescription" rows="4" readonly></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Chat con el ciudadano</label>
                                <div id="supportMessages" class="border rounded bg-light p-3" style="height: 260px; overflow-y: auto;"></div>
                                <div class="small text-muted mt-1">La conversacion se actualiza automaticamente mientras el modal esta abierto.</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Responder al ciudadano</label>
                                <div class="input-group">
                                    <textarea name="x_mensaje" class="form-control" id="supportReply" rows="2" placeholder="Escribe tu respuesta para el ciudadano."></textarea>
                                    <button type="button" class="btn btn-pj-blue" id="sendSupportMessage">
                                        <i class="bi bi-send"></i> Enviar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-pj-blue">
                            <i class="bi bi-check2-circle me-1"></i> Guardar estado
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            let supportChatTimer = null;
            let activeSupportTicket = '';

            const supportMessagesUrl = '<?= url('/modulos/soporte-sla/mensajes') ?>';
            const supportSendUrl = '<?= url('/modulos/soporte-sla/mensaje') ?>';
            const supportBox = document.getElementById('supportMessages');

            function escapeHtml(value) {
                return String(value ?? '')
                    .replaceAll('&', '&amp;')
                    .replaceAll('<', '&lt;')
                    .replaceAll('>', '&gt;')
                    .replaceAll('"', '&quot;')
                    .replaceAll("'", '&#039;');
            }

            function renderSupportMessages(messages) {
                if (!supportBox) {
                    return;
                }

                if (!messages || messages.length === 0) {
                    supportBox.innerHTML = '<div class="text-center text-muted small py-4">Aun no hay mensajes en este soporte.</div>';
                    return;
                }

                supportBox.innerHTML = messages.map((message) => {
                    const isAdmin = message.x_origen === 'ADMIN';
                    const isBot = message.x_origen === 'BOT';
                    const align = isAdmin ? 'justify-content-end' : '';
                    const bubble = isAdmin ? 'bg-pj-blue text-white' : (isBot ? 'bg-info-subtle border' : 'bg-white border');
                    const date = message.f_registro ? new Date(String(message.f_registro).replace(' ', 'T')).toLocaleString('es-PE') : '';
                    return `
                        <div class="d-flex ${align} mb-2">
                            <div class="${bubble} rounded p-2 small" style="max-width: 82%;">
                                <div class="fw-bold mb-1">${escapeHtml(message.x_origen)}</div>
                                <div>${escapeHtml(message.x_mensaje).replaceAll('\\n', '<br>')}</div>
                                <div class="${isAdmin ? 'text-white-50' : 'text-muted'}" style="font-size: 10px;">${escapeHtml(date)}</div>
                            </div>
                        </div>
                    `;
                }).join('');
                supportBox.scrollTop = supportBox.scrollHeight;
            }

            async function loadSupportMessages() {
                if (!activeSupportTicket) {
                    return;
                }

                try {
                    const response = await fetch(`${supportMessagesUrl}?ticket=${encodeURIComponent(activeSupportTicket)}`, {
                        headers: {'Accept': 'application/json'}
                    });
                    const data = await response.json();
                    if (data.ok) {
                        renderSupportMessages(data.messages);
                    }
                } catch (error) {
                    console.warn('No se pudo actualizar el chat SLA.', error);
                }
            }

            document.getElementById('supportStatusModal')?.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                activeSupportTicket = button?.getAttribute('data-codigo') || '';
                document.getElementById('supportCode').value = activeSupportTicket;
                document.getElementById('supportRequest').value = 'Solicitud #' + (button?.getAttribute('data-solicitud') || '');
                document.getElementById('supportDocument').value = button?.getAttribute('data-documento') || '';
                document.getElementById('supportReason').value = button?.getAttribute('data-motivo') || '';
                document.getElementById('supportState').value = button?.getAttribute('data-estado') || 'PENDIENTE';
                document.getElementById('supportDescription').value = button?.getAttribute('data-descripcion') || '';
                renderSupportMessages([]);
                loadSupportMessages();
                clearInterval(supportChatTimer);
                supportChatTimer = setInterval(loadSupportMessages, 4000);
            });

            document.getElementById('supportStatusModal')?.addEventListener('hidden.bs.modal', function () {
                clearInterval(supportChatTimer);
                supportChatTimer = null;
                activeSupportTicket = '';
                document.getElementById('supportReply').value = '';
            });

            document.getElementById('sendSupportMessage')?.addEventListener('click', async function () {
                const reply = document.getElementById('supportReply');
                const message = reply.value.trim();
                if (!activeSupportTicket || message === '') {
                    reply.focus();
                    return;
                }

                const body = new URLSearchParams();
                body.set('c_solicitud_apoyo', activeSupportTicket);
                body.set('x_mensaje', message);

                this.disabled = true;
                try {
                    const response = await fetch(supportSendUrl, {
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
                        reply.value = '';
                        renderSupportMessages(data.messages);
                    }
                } finally {
                    this.disabled = false;
                    reply.focus();
                }
            });
        </script>
    <?php endif; ?>
</div>
    </div>
    <?php endif; ?>

    <?php if ($canArchivo): ?>
        <div class="modal fade" id="archiveLocationModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <form class="modal-content" method="post" action="<?= url('/modulos/archivo/ubicacion') ?>">
                    <div class="modal-header bg-pj-blue text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-geo-alt me-2"></i>Registrar ubicacion documental
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="c_solicitud" id="archiveLocationSolicitud">
                        <input type="hidden" name="c_corte" id="archiveLocationCorte">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label fw-bold">Solicitud</label>
                                <input type="text" class="form-control" id="archiveLocationLabel" readonly>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label fw-bold">Ciudadano</label>
                                <input type="text" class="form-control" id="archiveLocationCitizen" readonly>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Ubicacion</label>
                                <input type="text" name="ubicacion" class="form-control" required placeholder="Ej. Archivo Central, Estante 3, Caja 12, Folios 20-28">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Observacion</label>
                                <textarea name="observacion" class="form-control" rows="3" placeholder="Detalle de la busqueda o condicion del documento."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-pj-blue">
                            <i class="bi bi-check2-circle me-1"></i> Registrar ubicacion
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="archiveNotFoundModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <form class="modal-content" method="post" action="<?= url('/modulos/archivo/no-encontrado') ?>">
                    <div class="modal-header bg-pj-blue text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-search me-2"></i>Registrar documento no ubicado
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="c_solicitud" id="archiveNotFoundSolicitud">
                        <input type="hidden" name="c_corte" id="archiveNotFoundCorte">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Solicitud</label>
                            <input type="text" class="form-control" id="archiveNotFoundLabel" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Resultado de busqueda</label>
                            <textarea name="observacion" class="form-control" rows="4" required placeholder="Indica donde se busco y por que no se ubico la documentacion solicitada."></textarea>
                        </div>
                        <div class="alert alert-warning border-0 mb-0">
                            Este registro servira para que el area responsable prepare una respuesta u observacion formal al ciudadano.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-outline-warning">
                            <i class="bi bi-search me-1"></i> Registrar no ubicado
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="archivePrepareModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <form class="modal-content" method="post" action="<?= url('/modulos/archivo/preparar') ?>" enctype="multipart/form-data">
                    <div class="modal-header bg-pj-blue text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-paperclip me-2"></i>Adjuntar documento preparado
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="c_solicitud" id="archivePrepareSolicitud">
                        <input type="hidden" name="c_corte" id="archivePrepareCorte">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label fw-bold">Solicitud</label>
                                <input type="text" class="form-control" id="archivePrepareLabel" readonly>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label fw-bold">Ciudadano</label>
                                <input type="text" class="form-control" id="archivePrepareCitizen" readonly>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Documento ubicado o copia preparada</label>
                                <input type="file" name="documento" class="form-control" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Observacion</label>
                                <textarea name="observacion" class="form-control" rows="3" placeholder="Ej. Copia digital del documento ubicado en Archivo Central."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-pj-blue">
                            <i class="bi bi-paperclip me-1"></i> Guardar documento
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="archiveRemitModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <form class="modal-content" method="post" action="<?= url('/modulos/archivo/remitir') ?>">
                    <div class="modal-header bg-pj-blue text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-send me-2"></i>Remitir resultado de Archivo
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="c_solicitud" id="archiveRemitSolicitud">
                        <input type="hidden" name="c_corte" id="archiveRemitCorte">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label fw-bold">Solicitud</label>
                                <input type="text" class="form-control" id="archiveRemitLabel" readonly>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label fw-bold">Ciudadano</label>
                                <input type="text" class="form-control" id="archiveRemitCitizen" readonly>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Destino</label>
                                <select name="destino" class="form-select" required>
                                    <option value="SECRETARIA GENERAL">1. Secretaria General - revisa y prepara respuesta formal</option>
                                    <option value="TRANSPARENCIA">2. Transparencia - revisa resultado y cierra derivacion</option>
                                    <option value="ASISTENCIA ADMINISTRATIVA">3. Asistencia Administrativa - registra respuesta o firma posterior</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Observacion</label>
                                <textarea name="observacion" class="form-control" rows="3" placeholder="Ej. Se remite documento ubicado para preparacion de respuesta al ciudadano."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-pj-blue">
                            <i class="bi bi-send me-1"></i> Confirmar remision
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function fillArchiveModal(prefix, button) {
                const solicitud = button?.getAttribute('data-solicitud') || '';
                document.getElementById(prefix + 'Solicitud').value = solicitud;
                document.getElementById(prefix + 'Corte').value = button?.getAttribute('data-corte') || '';
                document.getElementById(prefix + 'Label').value = 'Solicitud #' + solicitud;
                const citizen = document.getElementById(prefix + 'Citizen');
                if (citizen) {
                    citizen.value = button?.getAttribute('data-ciudadano') || '';
                }
            }

            document.getElementById('archiveLocationModal')?.addEventListener('show.bs.modal', (event) => fillArchiveModal('archiveLocation', event.relatedTarget));
            document.getElementById('archiveNotFoundModal')?.addEventListener('show.bs.modal', (event) => fillArchiveModal('archiveNotFound', event.relatedTarget));
            document.getElementById('archivePrepareModal')?.addEventListener('show.bs.modal', (event) => fillArchiveModal('archivePrepare', event.relatedTarget));
            document.getElementById('archiveRemitModal')?.addEventListener('show.bs.modal', (event) => fillArchiveModal('archiveRemit', event.relatedTarget));
        </script>
    <?php endif; ?>

    <?php if ($canMesaPartes): ?>
        <div class="modal fade" id="remitMesaModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <form class="modal-content" method="post" action="<?= url('/modulos/mesa-partes/remitir') ?>">
                    <div class="modal-header bg-pj-blue text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-send me-2"></i>Remitir solicitud
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="c_solicitud" id="mesaRemitSolicitud">
                        <input type="hidden" name="c_corte" id="mesaRemitCorte">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label fw-bold">Solicitud</label>
                                <input type="text" class="form-control" id="mesaRemitLabel" readonly>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label fw-bold">Ciudadano</label>
                                <input type="text" class="form-control" id="mesaRemitCitizen" readonly>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Destino</label>
                                <select name="destino" class="form-select" required>
                                    <option value="TRANSPARENCIA">1. Transparencia - revisar, calificar y derivar la solicitud</option>
                                    <option value="SECRETARIA GENERAL">2. Secretaria General - resoluciones, acuerdos e informacion administrativa</option>
                                    <option value="ARCHIVO CENTRAL">3. Archivo Central - busqueda documental, copias y anexos archivados</option>
                                    <option value="ADMINISTRACION DE CORTE">4. Administracion de Corte - informacion operativa de la sede</option>
                                    <option value="ODANC">5. ODANC - control, auditoria, quejas o plazos vencidos</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Observacion</label>
                                <textarea name="observacion" class="form-control" rows="3" placeholder="Ej. Solicitud validada y remitida para evaluacion de transparencia."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-pj-blue">
                            <i class="bi bi-send me-1"></i> Confirmar remision
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="modal fade" id="observeMesaModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <form class="modal-content" method="post" action="<?= url('/modulos/mesa-partes/observar') ?>">
                    <div class="modal-header bg-pj-blue text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-exclamation-circle me-2"></i>Observar ingreso
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="c_solicitud" id="mesaObserveSolicitud">
                        <input type="hidden" name="c_corte" id="mesaObserveCorte">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Solicitud</label>
                            <input type="text" class="form-control" id="mesaObserveLabel" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Motivo de observacion</label>
                            <textarea name="observacion" class="form-control" rows="4" required placeholder="Ej. El documento adjunto no abre correctamente o falta informacion para validar el ingreso."></textarea>
                        </div>
                        <div class="alert alert-warning border-0 mb-0">
                            Esta observacion quedara en la trazabilidad para que el ciudadano y las areas internas identifiquen el problema.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-outline-warning">
                            <i class="bi bi-exclamation-circle me-1"></i> Registrar observacion
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            document.getElementById('remitMesaModal')?.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const solicitud = button?.getAttribute('data-solicitud') || '';
                document.getElementById('mesaRemitSolicitud').value = solicitud;
                document.getElementById('mesaRemitCorte').value = button?.getAttribute('data-corte') || '';
                document.getElementById('mesaRemitLabel').value = 'Solicitud #' + solicitud;
                document.getElementById('mesaRemitCitizen').value = button?.getAttribute('data-ciudadano') || '';
            });

            document.getElementById('observeMesaModal')?.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const solicitud = button?.getAttribute('data-solicitud') || '';
                document.getElementById('mesaObserveSolicitud').value = solicitud;
                document.getElementById('mesaObserveCorte').value = button?.getAttribute('data-corte') || '';
                document.getElementById('mesaObserveLabel').value = 'Solicitud #' + solicitud;
            });
        </script>
    <?php endif; ?>

    <?php if ($canAssistantSign): ?>
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-pj-blue">
                    <i class="bi bi-file-earmark-check me-2"></i>Documentos firmados
                </h6>
            </div>
            <div class="card-body">
                <?php if (empty($signedRows ?? [])): ?>
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-file-earmark-lock fs-2 d-block mb-2"></i>
                        Aun no hay documentos firmados.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <?php foreach ($signedVisibleColumns as $column): ?>
                                        <th><?= e((string) $column) ?></th>
                                    <?php endforeach; ?>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($signedRows as $signed): ?>
                                    <?php $signedId = (int) ($signed['_respuesta_id'] ?? $signed['_RespuestaId'] ?? $signed['respuesta_id'] ?? $signed['c_solicitud_respuesta'] ?? 0); ?>
                                    <tr>
                                        <?php foreach ($signedVisibleColumns as $column): ?>
                                            <td class="small"><?= e((string) ($signed[$column] ?? '')) ?></td>
                                        <?php endforeach; ?>
                                        <td class="text-end">
                                            <button type="button"
                                                    class="btn btn-sm btn-pj-blue"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#signedDocumentModal"
                                                    data-url="<?= e(url('/documentos/firmado?id=' . $signedId)) ?>">
                                                <i class="bi bi-eye"></i> Ver detalle
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="modal fade" id="signedDocumentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-pj-blue text-white">
                        <h5 class="modal-title">
                            <i class="bi bi-file-earmark-check me-2"></i>Detalle del documento firmado
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body p-0">
                        <iframe id="signedDocumentFrame" class="w-100 border-0" style="height: 78vh;" title="Documento firmado"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('signedDocumentModal')?.addEventListener('show.bs.modal', function (event) {
                const url = event.relatedTarget?.getAttribute('data-url') || 'about:blank';
                const separator = url.includes('?') ? '&' : '?';
                document.getElementById('signedDocumentFrame').src = url === 'about:blank' ? url : url + separator + 'v=' + Date.now();
            });

            document.getElementById('signedDocumentModal')?.addEventListener('hidden.bs.modal', function () {
                document.getElementById('signedDocumentFrame').src = 'about:blank';
            });
        </script>
    <?php endif; ?>
</div>

<?php if ($canAssistantSign): ?>
    <div class="modal fade" id="signResponseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form class="modal-content" method="post" action="<?= url('/modulos/firmar-respuesta') ?>" enctype="multipart/form-data">
                <div class="modal-header bg-pj-blue text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-pen me-2"></i>Registrar respuesta firmada
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="c_solicitud" id="signSolicitud">
                    <input type="hidden" name="c_anexo" id="signAnexo">

                    <div class="alert alert-info border-0">
                        Asistencia revisa el documento que subio el ciudadano, aplica la firma digital en todas las hojas y registra la respuesta en la plataforma. Luego la solicitud queda como ATENDIDO para que el ciudadano vea la respuesta.
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Solicitud</label>
                            <input type="text" class="form-control" id="signSolicitudLabel" readonly>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Ciudadano</label>
                            <input type="text" class="form-control" id="signCitizen" readonly>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Documento del ciudadano</label>
                            <div class="border rounded bg-light p-2">
                                <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                                    <select class="form-select form-select-sm" id="citizenDocumentSelect"></select>
                                    <a class="btn btn-sm btn-outline-secondary text-nowrap" href="#" id="openCitizenDocument" target="_blank" rel="noopener">
                                        <i class="bi bi-box-arrow-up-right"></i> Abrir
                                    </a>
                                </div>
                                <div id="citizenDocumentEmpty" class="text-center text-muted small py-4 d-none">
                                    Esta solicitud no tiene documentos adjuntos del ciudadano.
                                </div>
                                <iframe id="citizenDocumentViewer" class="w-100 border rounded bg-white" style="height: 360px;" title="Visor del documento ciudadano"></iframe>
                                <div id="citizenDocumentFallback" class="text-muted small mt-2 d-none">
                                    Este tipo de archivo no se puede previsualizar aqui. Usa Abrir para revisarlo.
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="firmar_todas_hojas" value="1" id="signAllPages" checked>
                                <label class="form-check-label fw-bold" for="signAllPages">
                                    Aplicar firma digital en todas las hojas del documento seleccionado
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Firma digital de jefatura</label>
                            <div class="border rounded bg-light p-2">
                                <div class="small text-muted mb-2">
                                    Corte de la solicitud: <strong id="signatureRequestCourt"></strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                                    <select name="c_firma_jefe" class="form-select form-select-sm" id="bossSignatureSelect" required></select>
                                    <button type="button" class="btn btn-sm btn-outline-secondary text-nowrap" id="previewBossSignature">
                                        <i class="bi bi-eye"></i> Ver firma
                                    </button>
                                </div>
                                <div id="bossSignatureEmpty" class="text-center text-muted small py-3 d-none">
                                    No hay firma registrada para esta corte. Si ves firmas con "otra corte", entra con jefe@pj.gob.pe y edita la corte de la firma o registra una nueva para esta solicitud.
                                </div>
                                <div id="bossSignaturePreview" class="bg-white border rounded p-2 d-none">
                                    <img id="bossSignatureImage" class="img-fluid d-none" style="max-height: 160px;" alt="Firma de jefatura">
                                    <iframe id="bossSignatureFrame" class="w-100 border-0 d-none" style="height: 220px;" title="Visor firma de jefatura"></iframe>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Documento firmado opcional</label>
                            <input type="file" name="respuesta" class="form-control" accept=".pdf,.doc,.docx">
                            <div class="form-text">Si ya tienes un PDF firmado externamente, adjuntalo aqui. Si lo dejas vacio, se registrara la firma sobre el documento del ciudadano.</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Observacion de atencion</label>
                            <textarea name="observacion" class="form-control" rows="3">Firma digital aplicada en todas las hojas del documento del ciudadano y registrada en plataforma.</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-pj-blue" id="confirmSignedResponse">
                        <i class="bi bi-check2-circle me-1"></i> Confirmar firma
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('signResponseModal')?.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const solicitud = button?.getAttribute('data-solicitud') || '';
            const ciudadano = button?.getAttribute('data-ciudadano') || '';
            const corteSolicitud = button?.getAttribute('data-corte') || '';
            const anexos = JSON.parse(button?.getAttribute('data-anexos') || '[]');
            const firmas = JSON.parse(button?.getAttribute('data-firmas') || '[]');
            const select = document.getElementById('citizenDocumentSelect');
            const iframe = document.getElementById('citizenDocumentViewer');
            const link = document.getElementById('openCitizenDocument');
            const empty = document.getElementById('citizenDocumentEmpty');
            const fallback = document.getElementById('citizenDocumentFallback');
            const signatureSelect = document.getElementById('bossSignatureSelect');
            const signatureEmpty = document.getElementById('bossSignatureEmpty');
            const signaturePreview = document.getElementById('bossSignaturePreview');
            const signatureImage = document.getElementById('bossSignatureImage');
            const signatureFrame = document.getElementById('bossSignatureFrame');
            const confirmButton = document.getElementById('confirmSignedResponse');

            document.getElementById('signSolicitud').value = solicitud;
            document.getElementById('signSolicitudLabel').value = 'Solicitud #' + solicitud;
            document.getElementById('signCitizen').value = ciudadano;
            document.getElementById('signatureRequestCourt').textContent = corteSolicitud || 'Sin corte';

            select.innerHTML = '';
            anexos.forEach((doc) => {
                const option = document.createElement('option');
                option.value = doc.url;
                option.textContent = doc.name;
                option.dataset.id = doc.id;
                option.dataset.pdf = doc.isPdf ? '1' : '0';
                select.appendChild(option);
            });

            const renderDocument = () => {
                const option = select.options[select.selectedIndex];
                const hasDocument = Boolean(option);
                empty.classList.toggle('d-none', hasDocument);
                iframe.classList.toggle('d-none', !hasDocument || option.dataset.pdf !== '1');
                fallback.classList.toggle('d-none', !hasDocument || option.dataset.pdf === '1');
                link.classList.toggle('disabled', !hasDocument);
                link.href = hasDocument ? option.value : '#';
                iframe.src = hasDocument && option.dataset.pdf === '1' ? option.value : 'about:blank';
                document.getElementById('signAnexo').value = hasDocument ? option.dataset.id : '';
            };

            select.onchange = renderDocument;
            renderDocument();

            signatureSelect.innerHTML = '';
            firmas.forEach((firma) => {
                const option = document.createElement('option');
                option.value = firma.id;
                option.textContent = firma.juez + ' - ' + firma.cargo + ' | ' + firma.corte + (firma.compatible ? '' : ' (otra corte)');
                option.dataset.url = firma.url;
                option.dataset.pdf = firma.isPdf ? '1' : '0';
                option.dataset.compatible = firma.compatible ? '1' : '0';
                option.disabled = !firma.compatible;
                signatureSelect.appendChild(option);
            });

            const firstCompatible = Array.from(signatureSelect.options).find((option) => option.dataset.compatible === '1');
            if (firstCompatible) {
                signatureSelect.value = firstCompatible.value;
            }

            const renderSignature = () => {
                const option = signatureSelect.options[signatureSelect.selectedIndex];
                const hasSignature = Boolean(option);
                const hasCompatibleSignature = Boolean(option && option.dataset.compatible === '1');
                signatureEmpty.classList.toggle('d-none', hasCompatibleSignature);
                signaturePreview.classList.toggle('d-none', !hasSignature);
                signatureImage.classList.add('d-none');
                signatureFrame.classList.add('d-none');
                confirmButton.disabled = !hasCompatibleSignature;

                if (!hasSignature) {
                    return;
                }

                if (option.dataset.pdf === '1') {
                    signatureFrame.src = option.dataset.url;
                    signatureFrame.classList.remove('d-none');
                    return;
                }

                signatureImage.src = option.dataset.url;
                signatureImage.classList.remove('d-none');
            };

            signatureSelect.onchange = renderSignature;
            document.getElementById('previewBossSignature').onclick = renderSignature;
            renderSignature();
        });
    </script>
<?php endif; ?>
<?php $content = ob_get_clean(); require dirname(__DIR__) . '/layouts/app.php'; ?>
