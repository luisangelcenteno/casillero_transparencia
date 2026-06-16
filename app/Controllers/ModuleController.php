<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Support\AuditLogger;

class ModuleController extends Controller
{
    private array $modules = [
        'bandeja-entrada' => ['perfil' => '02', 'titulo' => 'Bandeja de Entrada', 'seccion' => 'Transparencia', 'icono' => 'bi-inboxes', 'descripcion' => 'Solicitudes recibidas para evaluacion y atencion inicial.'],
        'derivar-expedientes' => ['perfil' => '02', 'titulo' => 'Derivar Documentos', 'seccion' => 'Transparencia', 'icono' => 'bi-arrow-left-right', 'descripcion' => 'Modulo para enviar solicitudes y documentos hacia unidades o areas responsables.'],
        'supervision' => ['perfil' => '03', 'titulo' => 'Supervision', 'seccion' => 'Jefatura', 'icono' => 'bi-diagram-3', 'descripcion' => 'Vista de seguimiento para jefaturas administrativas.'],
        'reportes' => ['perfil' => '03', 'titulo' => 'Reportes', 'seccion' => 'Jefatura', 'icono' => 'bi-graph-up', 'descripcion' => 'Indicadores administrativos y reportes de gestion.'],
        'actualizar-estados' => ['perfil' => '04', 'titulo' => 'Actualizar Estados', 'seccion' => 'Asistencia', 'icono' => 'bi-clipboard-check', 'descripcion' => 'Actualizacion operativa del estado de las solicitudes.'],
        'adjuntar-documentos' => ['perfil' => '04', 'titulo' => 'Adjuntar Documentos', 'seccion' => 'Asistencia', 'icono' => 'bi-paperclip', 'descripcion' => 'Gestion de anexos y documentos de respuesta.'],
        'alertas-sla' => ['perfil' => '05', 'titulo' => 'Alertas SLA', 'seccion' => 'Control ODANC', 'icono' => 'bi-stopwatch', 'descripcion' => 'Control de solicitudes en riesgo o fuera de plazo.'],
        'auditoria' => ['perfil' => '05', 'titulo' => 'Auditoria', 'seccion' => 'Control ODANC', 'icono' => 'bi-shield-exclamation', 'descripcion' => 'Revision de cumplimiento y trazabilidad de atenciones.'],
        'busqueda-documental' => ['perfil' => '06', 'titulo' => 'Busqueda Documental', 'seccion' => 'Archivo', 'icono' => 'bi-archive', 'descripcion' => 'Busqueda y ubicacion de documentacion solicitada.'],
        'preparar-anexos' => ['perfil' => '06', 'titulo' => 'Preparar Anexos', 'seccion' => 'Archivo', 'icono' => 'bi-folder-check', 'descripcion' => 'Preparacion de anexos para respuesta documentaria.'],
        'validar-ingresos' => ['perfil' => '07', 'titulo' => 'Validar Ingresos', 'seccion' => 'Mesa de Partes', 'icono' => 'bi-envelope-paper', 'descripcion' => 'Revision de datos de solicitudes ingresadas.'],
        'remitir-solicitudes' => ['perfil' => '07', 'titulo' => 'Remitir Solicitudes', 'seccion' => 'Mesa de Partes', 'icono' => 'bi-send-check', 'descripcion' => 'Remision inicial hacia transparencia o areas competentes.'],
        'indicadores' => ['perfil' => '08', 'titulo' => 'Indicadores', 'seccion' => 'Supervision General', 'icono' => 'bi-bar-chart', 'descripcion' => 'Panel de indicadores globales del proceso.'],
        'coordinacion' => ['perfil' => '08', 'titulo' => 'Coordinacion', 'seccion' => 'Supervision General', 'icono' => 'bi-people', 'descripcion' => 'Coordinacion entre perfiles y areas operativas.'],
        'analisis-sla' => ['perfil' => '09', 'titulo' => 'Analisis SLA', 'seccion' => 'Auditoria de Plazos', 'icono' => 'bi-stopwatch-fill', 'descripcion' => 'Analisis especializado de plazos de atencion.'],
        'incumplimientos' => ['perfil' => '09', 'titulo' => 'Incumplimientos', 'seccion' => 'Auditoria de Plazos', 'icono' => 'bi-clipboard-data', 'descripcion' => 'Listado de riesgos e incumplimientos detectados.'],
        'usuarios' => ['perfil' => '10', 'titulo' => 'Usuarios', 'seccion' => 'Administracion', 'icono' => 'bi-person-gear', 'descripcion' => 'Usuarios registrados y perfil asignado.'],
        'perfiles' => ['perfil' => '10', 'titulo' => 'Perfiles', 'seccion' => 'Administracion', 'icono' => 'bi-person-badge', 'descripcion' => 'Catalogo de perfiles habilitados en el sistema.'],
        'catalogos' => ['perfil' => '10', 'titulo' => 'Catalogos', 'seccion' => 'Administracion', 'icono' => 'bi-sliders', 'descripcion' => 'Resumen de catalogos maestros disponibles.'],
        'soporte-sla' => ['perfil' => '10', 'titulo' => 'Soporte SLA', 'seccion' => 'Administracion', 'icono' => 'bi-life-preserver', 'descripcion' => 'Incidencias por documentos faltantes, equivocados o danados.'],
        'pagos-culqi' => ['perfil' => '10', 'titulo' => 'Pagos Culqi', 'seccion' => 'Administracion', 'icono' => 'bi-credit-card', 'descripcion' => 'Pagos de reproduccion, copias fisicas, certificadas y envios.'],
        'auditoria-sistema' => ['perfil' => '10', 'titulo' => 'Registro Auditoria', 'seccion' => 'Administracion', 'icono' => 'bi-journal-check', 'descripcion' => 'Log transversal de eventos criticos del sistema y trazabilidad tecnica.'],
    ];

    public function show(): void
    {
        $this->requireAuth();

        $slug = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '');
        $module = $this->modules[$slug] ?? null;

        if (!$module) {
            http_response_code(404);
            echo 'Modulo no encontrado.';
            return;
        }

        $perfil = $_SESSION['id_perfil'] ?? '';
        if (!$this->canAccessModule($perfil, $slug, $module)) {
            $this->redirect('/dashboard');
        }

        $this->view($slug === 'bandeja-entrada' ? 'modules.inbox' : 'modules.show', [
            'module' => $module,
            'slug' => $slug,
            'rows' => $this->rowsFor($slug),
            'signedRows' => in_array($slug, ['actualizar-estados', 'adjuntar-documentos'], true) ? $this->documentosFirmados() : [],
            'reportStats' => $slug === 'reportes' ? $this->reportStats() : [],
            'reportRows' => $slug === 'reportes' ? $this->reportRows() : [],
            'supportRows' => $slug === 'reportes' ? $this->soporteSla() : [],
            'cortes' => $this->cortes(),
            'firmasJefes' => $this->firmasJefes($this->shouldShowOnlyOwnSignatures($slug)),
        ]);
    }

    public function derive(): void
    {
        $this->requireAuth();

        $perfil = $_SESSION['id_perfil'] ?? '';
        if (!in_array($perfil, ['02', '10'], true)) {
            $this->redirect('/dashboard');
        }

        $solicitud = (int) ($_POST['c_solicitud'] ?? 0);
        $corte = trim($_POST['c_corte'] ?? '');
        $destino = trim($_POST['destino'] ?? '');
        $observacion = trim($_POST['observacion'] ?? '');

        if ($solicitud <= 0 || $corte === '') {
            $this->redirect('/modulos/bandeja-entrada?error=derivacion');
        }

        $texto = 'DERIVADO A: ' . ($destino ?: 'AREA COMPETENTE');
        if ($observacion !== '') {
            $texto .= ' | ' . $observacion;
        }

        $sql = "INSERT INTO solicitudes_ubicaciones (
                    c_solicitud, c_usuario, c_tipo_solicitud_estado, c_corte,
                    x_observacion, l_estado, b_aud, c_aud, n_aud_ip
                ) VALUES (
                    :solicitud, :usuario, '02', :corte,
                    :observacion, 'S', 'I', :auditoria, :ip
                )";

        Database::connection()->prepare($sql)->execute([
            'solicitud' => $solicitud,
            'usuario' => (int) ($_SESSION['id_usuario'] ?? 0),
            'corte' => $corte,
            'observacion' => mb_strtoupper($texto, 'UTF-8'),
            'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
        ]);

        AuditLogger::record(
            'ASIGNACION Y VALIDACION',
            'TRANSPARENCIA',
            'DERIVACION DE DOCUMENTOS',
            $solicitud,
            $texto
        );

        $this->redirect('/modulos/bandeja-entrada?msg=derivado');
    }

    public function validateIncome(): void
    {
        $this->requireAuth();

        if (!$this->canMesaPartesAct()) {
            $this->redirect('/dashboard');
        }

        $solicitud = (int) ($_POST['c_solicitud'] ?? 0);
        $corte = trim($_POST['c_corte'] ?? '');

        if ($solicitud <= 0 || $corte === '') {
            $this->redirect('/modulos/validar-ingresos?error=mesa');
        }

        $texto = 'VALIDADO POR MESA DE PARTES | SOLICITUD Y DOCUMENTOS RECIBIDOS CORRECTAMENTE | PENDIENTE DE REMISION';
        if ($this->latestMovementStartsWith($solicitud, 'VALIDADO POR MESA DE PARTES')) {
            $this->redirect('/modulos/validar-ingresos?msg=mesa_ya_validado');
        }

        $this->insertRequestMovement(
            $solicitud,
            $corte,
            '02',
            $texto
        );

        AuditLogger::record(
            'VALIDACION Y CARGO',
            'MESA DE PARTES',
            'VALIDACION DE INGRESO',
            $solicitud,
            $texto
        );

        $this->redirect('/modulos/validar-ingresos?msg=mesa_validado');
    }

    public function remitIncome(): void
    {
        $this->requireAuth();

        if (!$this->canMesaPartesAct()) {
            $this->redirect('/dashboard');
        }

        $solicitud = (int) ($_POST['c_solicitud'] ?? 0);
        $corte = trim($_POST['c_corte'] ?? '');
        $destino = trim($_POST['destino'] ?? 'TRANSPARENCIA');
        $observacion = trim($_POST['observacion'] ?? '');

        if ($solicitud <= 0 || $corte === '') {
            $this->redirect('/modulos/remitir-solicitudes?error=mesa');
        }

        $texto = 'REMITIDO POR MESA DE PARTES A: ' . ($destino !== '' ? $destino : 'TRANSPARENCIA');
        if ($observacion !== '') {
            $texto .= ' | ' . $observacion;
        }

        $this->insertRequestMovement($solicitud, $corte, '02', $texto);
        AuditLogger::record(
            'ASIGNACION Y VALIDACION',
            'MESA DE PARTES',
            'REMISION DE SOLICITUD',
            $solicitud,
            $texto
        );
        $this->redirect('/modulos/remitir-solicitudes?msg=mesa_remitido');
    }

    public function observeIncome(): void
    {
        $this->requireAuth();

        if (!$this->canMesaPartesAct()) {
            $this->redirect('/dashboard');
        }

        $solicitud = (int) ($_POST['c_solicitud'] ?? 0);
        $corte = trim($_POST['c_corte'] ?? '');
        $observacion = trim($_POST['observacion'] ?? '');

        if ($solicitud <= 0 || $corte === '' || $observacion === '') {
            $this->redirect('/modulos/validar-ingresos?error=mesa');
        }

        $this->insertRequestMovement(
            $solicitud,
            $corte,
            '01',
            'OBSERVADO POR MESA DE PARTES | ' . $observacion
        );

        AuditLogger::record(
            'VALIDACION Y CARGO',
            'MESA DE PARTES',
            'OBSERVACION DE INGRESO',
            $solicitud,
            $observacion
        );

        $this->redirect('/modulos/validar-ingresos?msg=mesa_observado');
    }

    public function archiveLocation(): void
    {
        $this->requireAuth();

        if (!$this->canArchivoAct()) {
            $this->redirect('/dashboard');
        }

        $solicitud = (int) ($_POST['c_solicitud'] ?? 0);
        $corte = trim($_POST['c_corte'] ?? '');
        $ubicacion = trim($_POST['ubicacion'] ?? '');
        $observacion = trim($_POST['observacion'] ?? '');

        if ($solicitud <= 0 || $corte === '' || $ubicacion === '') {
            $this->redirect('/modulos/busqueda-documental?error=archivo');
        }

        $texto = 'ARCHIVO CENTRAL | DOCUMENTACION UBICADA EN: ' . $ubicacion;
        if ($observacion !== '') {
            $texto .= ' | ' . $observacion;
        }

        $this->insertRequestMovement($solicitud, $corte, '02', $texto);
        AuditLogger::record(
            'ATENCION DE SOLICITUD',
            'ARCHIVO CENTRAL',
            'REGISTRO DE UBICACION DOCUMENTAL',
            $solicitud,
            $texto
        );
        $this->redirect('/modulos/busqueda-documental?msg=archivo_ubicado');
    }

    public function archiveNotFound(): void
    {
        $this->requireAuth();

        if (!$this->canArchivoAct()) {
            $this->redirect('/dashboard');
        }

        $solicitud = (int) ($_POST['c_solicitud'] ?? 0);
        $corte = trim($_POST['c_corte'] ?? '');
        $observacion = trim($_POST['observacion'] ?? '');

        if ($solicitud <= 0 || $corte === '' || $observacion === '') {
            $this->redirect('/modulos/busqueda-documental?error=archivo');
        }

        $this->insertRequestMovement(
            $solicitud,
            $corte,
            '02',
            'ARCHIVO CENTRAL | DOCUMENTACION NO UBICADA | ' . $observacion
        );

        AuditLogger::record(
            'ATENCION DE SOLICITUD',
            'ARCHIVO CENTRAL',
            'DOCUMENTACION NO UBICADA',
            $solicitud,
            $observacion
        );

        $this->redirect('/modulos/busqueda-documental?msg=archivo_no_encontrado');
    }

    public function archivePrepare(): void
    {
        $this->requireAuth();
        $this->ensureArchivoPreparacionesTable();

        if (!$this->canArchivoAct()) {
            $this->redirect('/dashboard');
        }

        $solicitud = (int) ($_POST['c_solicitud'] ?? 0);
        $corte = trim($_POST['c_corte'] ?? '');
        $observacion = trim($_POST['observacion'] ?? '');

        if ($solicitud <= 0 || $corte === '' || !isset($_FILES['documento']) || $_FILES['documento']['error'] !== UPLOAD_ERR_OK) {
            $this->redirect('/modulos/preparar-anexos?error=archivo');
        }

        $targetDir = dirname(__DIR__, 2) . '/storage/uploads/archivo/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $original = basename($_FILES['documento']['name']);
        $extension = strtolower(pathinfo($original, PATHINFO_EXTENSION) ?: 'pdf');
        $archivoSistema = 'ARCHIVO_SOL_' . $solicitud . '_' . time() . '.' . $extension;
        $rutaFisica = $targetDir . $archivoSistema;

        if (!move_uploaded_file($_FILES['documento']['tmp_name'], $rutaFisica)) {
            $this->redirect('/modulos/preparar-anexos?error=archivo');
        }

        Database::connection()->prepare("INSERT INTO archivo_preparaciones (
                                             c_solicitud, c_usuario, c_corte,
                                             x_archivo, x_ubicacion, x_observacion,
                                             l_estado, c_aud, b_aud, n_aud_ip
                                         ) VALUES (
                                             :solicitud, :usuario, :corte,
                                             :archivo, :ubicacion, :observacion,
                                             'S', :auditoria, 'I', :ip
                                         )")->execute([
            'solicitud' => $solicitud,
            'usuario' => (int) ($_SESSION['id_usuario'] ?? 0),
            'corte' => $corte,
            'archivo' => substr($original, 0, 100),
            'ubicacion' => 'uploads/archivo/' . $archivoSistema,
            'observacion' => $observacion,
            'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
            'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
        ]);

        $seqStmt = Database::connection()->prepare("SELECT COALESCE(MAX(n_secuencia), 0) + 1
                                                    FROM solicitudes_anexos
                                                    WHERE c_solicitud = :solicitud");
        $seqStmt->execute(['solicitud' => $solicitud]);
        $secuencia = (int) $seqStmt->fetchColumn();

        Database::connection()->prepare("INSERT INTO solicitudes_anexos (
                                             c_solicitud, n_secuencia, x_archivo, x_ubicacion,
                                             l_estado, c_aud, b_aud, n_aud_ip
                                         ) VALUES (
                                             :solicitud, :secuencia, :archivo, :ubicacion,
                                             'S', :auditoria, 'I', :ip
                                         )")->execute([
            'solicitud' => $solicitud,
            'secuencia' => $secuencia,
            'archivo' => substr('ARCHIVO_' . $original, 0, 100),
            'ubicacion' => substr('uploads/archivo/' . $archivoSistema, 0, 100),
            'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
            'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
        ]);

        $texto = 'ARCHIVO CENTRAL | DOCUMENTO PREPARADO COMO ANEXO DE RESPUESTA';
        if ($observacion !== '') {
            $texto .= ' | ' . $observacion;
        }

        $this->insertRequestMovement($solicitud, $corte, '02', $texto);
        AuditLogger::record(
            'ATENCION DE SOLICITUD',
            'ARCHIVO CENTRAL',
            'DOCUMENTO PREPARADO COMO ANEXO',
            $solicitud,
            $texto
        );
        $this->redirect('/modulos/preparar-anexos?msg=archivo_preparado');
    }

    public function archiveRemit(): void
    {
        $this->requireAuth();

        if (!$this->canArchivoAct()) {
            $this->redirect('/dashboard');
        }

        $solicitud = (int) ($_POST['c_solicitud'] ?? 0);
        $corte = trim($_POST['c_corte'] ?? '');
        $destino = trim($_POST['destino'] ?? 'SECRETARIA GENERAL');
        $observacion = trim($_POST['observacion'] ?? '');

        if ($solicitud <= 0 || $corte === '') {
            $this->redirect('/modulos/preparar-anexos?error=archivo');
        }

        $texto = 'ARCHIVO CENTRAL | DOCUMENTACION REMITIDA A: ' . ($destino !== '' ? $destino : 'SECRETARIA GENERAL');
        if ($observacion !== '') {
            $texto .= ' | ' . $observacion;
        }

        $this->insertRequestMovement($solicitud, $corte, '02', $texto);
        AuditLogger::record(
            'ASIGNACION Y VALIDACION',
            'ARCHIVO CENTRAL',
            'REMISION DE DOCUMENTACION',
            $solicitud,
            $texto
        );
        $this->redirect('/modulos/preparar-anexos?msg=archivo_remitido');
    }

    public function signResponse(): void
    {
        $this->requireAuth();
        $this->ensureFirmasTable();
        $this->ensureResponseSignaturesTable();

        $perfil = $_SESSION['id_perfil'] ?? '';
        if (!in_array($perfil, ['03', '04', '10'], true)) {
            $this->redirect('/dashboard');
        }

        $solicitud = (int) ($_POST['c_solicitud'] ?? 0);
        $anexoSeleccionado = (int) ($_POST['c_anexo'] ?? 0);
        $firmaJefe = (int) ($_POST['c_firma_jefe'] ?? 0);
        $observacion = trim($_POST['observacion'] ?? '');

        if ($solicitud <= 0 || $firmaJefe <= 0) {
            $this->redirect('/modulos/actualizar-estados?error=firma_jefe');
        }

        $pdo = Database::connection();
        $actualStmt = $pdo->prepare("SELECT c_solicitud_ubicacion, c_corte
                                     FROM solicitudes_ubicaciones
                                     WHERE c_solicitud = :solicitud AND l_estado = 'S'
                                     ORDER BY c_solicitud_ubicacion DESC
                                     LIMIT 1");
        $actualStmt->execute(['solicitud' => $solicitud]);
        $actual = $actualStmt->fetch();

        if (!$actual) {
            $this->redirect('/modulos/actualizar-estados?error=firma');
        }

        $firmaStmt = $pdo->prepare("SELECT *
                                    FROM firmas_jefes
                                    WHERE c_firma_jefe = :firma
                                      AND c_corte = :corte
                                      AND l_estado = 'S'
                                    LIMIT 1");
        $firmaStmt->execute([
            'firma' => $firmaJefe,
            'corte' => $actual['c_corte'],
        ]);
        $firma = $firmaStmt->fetch();

        if (!$firma) {
            $this->redirect('/modulos/actualizar-estados?error=firma_jefe');
        }

        $anexoSql = "SELECT x_archivo, x_ubicacion
                                    FROM solicitudes_anexos
                                    WHERE c_solicitud = :solicitud
                                      AND l_estado = 'S'
                                      AND (:anexo_filter = 0 OR c_solicitud_anexo = :anexo_id)
                                    ORDER BY n_secuencia, c_solicitud_anexo
                                    LIMIT 1";
        $anexoStmt = $pdo->prepare($anexoSql);
        $anexoStmt->execute([
            'solicitud' => $solicitud,
            'anexo_filter' => $anexoSeleccionado,
            'anexo_id' => $anexoSeleccionado,
        ]);
        $anexoBase = $anexoStmt->fetch();

        $archivoOriginal = $anexoBase
            ? 'FIRMADO_DIGITAL_' . $anexoBase['x_archivo']
            : 'RESPUESTA_FIRMADA_SOL_' . $solicitud . '.pdf';
        $ubicacion = $anexoBase
            ? $anexoBase['x_ubicacion']
            : 'uploads/respuestas/' . $archivoOriginal;

        if (isset($_FILES['respuesta']) && $_FILES['respuesta']['error'] === UPLOAD_ERR_OK && $_FILES['respuesta']['name'] !== '') {
            $targetDir = dirname(__DIR__, 2) . '/storage/uploads/respuestas/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $archivoOriginal = basename($_FILES['respuesta']['name']);
            $extension = pathinfo($archivoOriginal, PATHINFO_EXTENSION) ?: 'pdf';
            $archivoSistema = 'SOL_' . $solicitud . '_RESP_' . time() . '.' . $extension;
            $rutaFisica = $targetDir . $archivoSistema;

            if (move_uploaded_file($_FILES['respuesta']['tmp_name'], $rutaFisica)) {
                $ubicacion = 'uploads/respuestas/' . $archivoSistema;
            }
        }

        $pdo->beginTransaction();

        try {
            $seqStmt = $pdo->prepare("SELECT COALESCE(MAX(n_secuencia), 0) + 1
                                      FROM solicitudes_respuestas
                                      WHERE c_solicitud = :solicitud");
            $seqStmt->execute(['solicitud' => $solicitud]);
            $secuencia = (int) $seqStmt->fetchColumn();

            $respuestaSql = "INSERT INTO solicitudes_respuestas (
                                c_solicitud, c_solicitud_ubicacion, n_secuencia,
                                x_archivo, x_ubicacion, l_estado, c_aud, b_aud, n_aud_ip
                            ) VALUES (
                                :solicitud, :ubicacion_id, :secuencia,
                                :archivo, :ruta, 'S', :auditoria, 'I', :ip
                            )";

            $pdo->prepare($respuestaSql)->execute([
                'solicitud' => $solicitud,
                'ubicacion_id' => (int) $actual['c_solicitud_ubicacion'],
                'secuencia' => $secuencia,
                'archivo' => substr($archivoOriginal, 0, 100),
                'ruta' => substr($ubicacion, 0, 100),
                'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
                'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
            ]);
            $respuestaId = (int) $pdo->lastInsertId();

            $pdo->prepare("INSERT INTO solicitudes_respuestas_firmas (
                              c_solicitud_respuesta, c_firma_jefe, c_usuario_firma,
                              l_estado, c_aud, b_aud, n_aud_ip
                          ) VALUES (
                              :respuesta, :firma, :usuario_firma,
                              'S', :auditoria, 'I', :ip
                          )")->execute([
                'respuesta' => $respuestaId,
                'firma' => $firmaJefe,
                'usuario_firma' => (int) ($_SESSION['id_usuario'] ?? 0),
                'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
                'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
            ]);

            $this->generateSignedPdf($respuestaId);

            $texto = $observacion !== ''
                ? $observacion
                : 'FIRMA DIGITAL APLICADA EN TODAS LAS HOJAS DEL DOCUMENTO DEL CIUDADANO Y REGISTRADA EN PLATAFORMA';
            $texto .= ' | FIRMADO POR: ' . $firma['x_juez'] . ' - ' . $firma['x_cargo'];

            $ubicacionSql = "INSERT INTO solicitudes_ubicaciones (
                                c_solicitud, c_usuario, c_tipo_solicitud_estado, c_corte,
                                x_observacion, l_estado, b_aud, c_aud, n_aud_ip
                            ) VALUES (
                                :solicitud, :usuario, '04', :corte,
                                :observacion, 'S', 'I', :auditoria, :ip
                            )";

            $pdo->prepare($ubicacionSql)->execute([
                'solicitud' => $solicitud,
                'usuario' => (int) ($_SESSION['id_usuario'] ?? 0),
                'corte' => $actual['c_corte'],
                'observacion' => mb_strtoupper($texto, 'UTF-8'),
                'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
                'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
            ]);

            $pdo->commit();
        } catch (\Throwable $exception) {
            $pdo->rollBack();
            throw $exception;
        }

        AuditLogger::record(
            'GENERACION DE CARGO',
            'ASISTENCIA ADMINISTRATIVA',
            'RESPUESTA FIRMADA GENERADA',
            $solicitud,
            $texto
        );
        AuditLogger::record(
            'NOTIFICACION ENVIADA',
            'CASILLERO DIGITAL',
            'RESPUESTA DISPONIBLE PARA EL CIUDADANO',
            $solicitud,
            'Respuesta firmada #' . $respuestaId . ' publicada en el casillero del ciudadano.'
        );

        $this->redirect('/modulos/actualizar-estados?msg=firmado');
    }

    public function signedDocument(): void
    {
        $this->requireAuth();
        $this->ensureFirmasTable();
        $this->ensureResponseSignaturesTable();

        $respuestaId = (int) ($_GET['id'] ?? 0);
        if ($respuestaId <= 0) {
            $respuestaId = $this->latestSignedResponseId();
        }

        $this->generateSignedPdf($respuestaId);
        $data = $this->signedDocumentData($respuestaId);

        if (!$data) {
            http_response_code(404);
            echo 'Documento firmado no encontrado.';
            return;
        }

        $this->view('modules.signed-document', ['data' => $data]);
    }

    public function responseFile(): void
    {
        $this->requireAuth();

        $respuestaId = (int) ($_GET['id'] ?? 0);
        if ($respuestaId <= 0) {
            $respuestaId = $this->latestSignedResponseId();
        }

        $stmt = Database::connection()->prepare("SELECT * FROM solicitudes_respuestas WHERE c_solicitud_respuesta = :id AND l_estado = 'S'");
        $stmt->execute(['id' => $respuestaId]);
        $respuesta = $stmt->fetch();

        if (!$respuesta) {
            http_response_code(404);
            echo 'Documento no encontrado.';
            return;
        }

        $path = dirname(__DIR__, 2) . '/storage/' . ltrim($respuesta['x_ubicacion'], '/');
        if (!is_file($path)) {
            http_response_code(404);
            echo 'Archivo fisico no encontrado.';
            return;
        }

        $extension = strtolower(pathinfo($respuesta['x_archivo'], PATHINFO_EXTENSION));
        $mime = match ($extension) {
            'pdf' => 'application/pdf',
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'svg' => 'image/svg+xml',
            default => 'application/octet-stream',
        };

        $disposition = ($_GET['download'] ?? '') === '1' ? 'attachment' : 'inline';
        header('Content-Type: ' . $mime);
        header('Content-Disposition: ' . $disposition . '; filename="' . basename($respuesta['x_archivo']) . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }

    public function paidCopyFile(): void
    {
        $this->requireAuth();
        $this->ensureReproductionPaymentsTable();

        $paymentId = (int) ($_GET['id'] ?? 0);
        $stmt = Database::connection()->prepare("SELECT p.*, s.c_usuario AS solicitud_usuario
                                                 FROM pagos_reproduccion p
                                                 INNER JOIN solicitudes s ON p.c_solicitud = s.c_solicitud
                                                 WHERE p.c_pago_reproduccion = :pago
                                                   AND p.l_estado = 'S'
                                                 LIMIT 1");
        $stmt->execute(['pago' => $paymentId]);
        $payment = $stmt->fetch();

        if (!$payment) {
            http_response_code(404);
            echo 'Copia pagada no encontrada.';
            return;
        }

        $perfil = $_SESSION['id_perfil'] ?? '';
        $isOwner = (int) $payment['solicitud_usuario'] === (int) ($_SESSION['id_usuario'] ?? 0);
        if (!$isOwner && $perfil !== '10') {
            http_response_code(403);
            echo 'Acceso denegado.';
            return;
        }

        $path = dirname(__DIR__, 2) . '/storage/' . ltrim((string) ($payment['x_copia_ubicacion'] ?? ''), '/');
        if (empty($payment['x_copia_ubicacion']) || !is_file($path)) {
            http_response_code(404);
            echo 'La copia aun no fue preparada por Administracion del Sistema.';
            return;
        }

        $disposition = ($_GET['download'] ?? '') === '1' ? 'attachment' : 'inline';
        $filename = basename((string) ($payment['x_copia_archivo'] ?: 'copia_pagada.pdf'));
        header('Content-Type: application/pdf');
        header('Content-Disposition: ' . $disposition . '; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }

    public function prepareCulqiCopy(): void
    {
        $this->requireAuth();
        $this->ensureReproductionPaymentsTable();

        if (($_SESSION['id_perfil'] ?? '') !== '10') {
            $this->redirect('/dashboard');
        }

        $paymentId = (int) ($_POST['c_pago_reproduccion'] ?? 0);
        $payment = $this->paidCopyData($paymentId);

        if (!$payment) {
            $this->redirect('/modulos/pagos-culqi?error=copia');
        }

        $this->generateSignedPdf((int) $payment['c_solicitud_respuesta']);
        $payment = $this->paidCopyData($paymentId);
        $storage = dirname(__DIR__, 2) . '/storage/';
        $inputPath = $storage . ltrim((string) $payment['respuesta_ubicacion'], '/');

        if (!is_file($inputPath) || strtolower(pathinfo($inputPath, PATHINFO_EXTENSION)) !== 'pdf') {
            $this->redirect('/modulos/pagos-culqi?error=copia_archivo');
        }

        $outputName = 'COPIA_PAGO_' . $paymentId . '_SOL_' . (int) $payment['c_solicitud'] . '.pdf';
        $outputRelative = 'uploads/copias/' . $outputName;
        $outputPath = $storage . $outputRelative;
        $label = (string) ($payment['x_tipo_copia'] ?: 'COPIA SIMPLE');

        $script = dirname(__DIR__) . '/Support/copy_watermark.py';
        $python = 'C:\\Users\\Jose\\AppData\\Local\\Programs\\Python\\Python39\\python.exe';
        $command = '"' . $python . '" '
            . escapeshellarg($script) . ' '
            . escapeshellarg($inputPath) . ' '
            . escapeshellarg($outputPath) . ' '
            . escapeshellarg($label);

        exec($command, $output, $exitCode);
        if ($exitCode !== 0 || !is_file($outputPath)) {
            $this->redirect('/modulos/pagos-culqi?error=copia_generar');
        }

        Database::connection()->prepare("UPDATE pagos_reproduccion
                                         SET x_estado_entrega = 'PREPARADO',
                                             x_copia_archivo = :archivo,
                                             x_copia_ubicacion = :ubicacion,
                                             f_preparacion = CURRENT_TIMESTAMP(6),
                                             b_aud = 'U',
                                             f_aud = CURRENT_TIMESTAMP(6),
                                             c_aud = :usuario
                                         WHERE c_pago_reproduccion = :pago")
            ->execute([
                'archivo' => $outputName,
                'ubicacion' => $outputRelative,
                'usuario' => (int) ($_SESSION['id_usuario'] ?? 0),
                'pago' => $paymentId,
            ]);

        $this->registerPaidCopyMovement((int) $payment['c_solicitud'], $label . ' PREPARADA CON MARCA DE AGUA PARA ENTREGA AL CIUDADANO');
        AuditLogger::record(
            'COPIA PREPARADA',
            'PAGOS CULQI',
            'GENERACION DE COPIA CON MARCA DE AGUA',
            (int) $payment['c_solicitud'],
            $label . ' | Archivo: ' . $outputName
        );
        $this->redirect('/modulos/pagos-culqi?msg=copia_preparada');
    }

    public function deliverCulqiCopy(): void
    {
        $this->requireAuth();
        $this->ensureReproductionPaymentsTable();

        if (($_SESSION['id_perfil'] ?? '') !== '10') {
            $this->redirect('/dashboard');
        }

        $paymentId = (int) ($_POST['c_pago_reproduccion'] ?? 0);
        $payment = $this->paidCopyData($paymentId);

        if (!$payment || empty($payment['x_copia_ubicacion'])) {
            $this->redirect('/modulos/pagos-culqi?error=copia');
        }

        Database::connection()->prepare("UPDATE pagos_reproduccion
                                         SET x_estado_entrega = 'ENTREGADO',
                                             f_entrega = CURRENT_TIMESTAMP(6),
                                             b_aud = 'U',
                                             f_aud = CURRENT_TIMESTAMP(6),
                                             c_aud = :usuario
                                         WHERE c_pago_reproduccion = :pago")
            ->execute([
                'usuario' => (int) ($_SESSION['id_usuario'] ?? 0),
                'pago' => $paymentId,
            ]);

        $this->registerPaidCopyMovement((int) $payment['c_solicitud'], (string) $payment['x_tipo_copia'] . ' ENTREGADA AL CIUDADANO');
        AuditLogger::record(
            'COPIA ENTREGADA',
            'PAGOS CULQI',
            'ENTREGA DE COPIA AL CIUDADANO',
            (int) $payment['c_solicitud'],
            (string) $payment['x_tipo_copia'] . ' | Pago #' . $paymentId
        );
        $this->redirect('/modulos/pagos-culqi?msg=copia_entregada');
    }

    public function verifyDocument(): void
    {
        $code = trim($_GET['codigo'] ?? '');
        $valid = preg_match('/^CDT-(\d{6})-(\d{6})$/', $code, $matches) === 1;
        $data = null;

        if ($valid) {
            $stmt = Database::connection()->prepare("SELECT sr.c_solicitud_respuesta,
                                                            sr.c_solicitud,
                                                            sr.x_archivo,
                                                            sr.f_registro,
                                                            CONCAT(u.x_nombres, ' ', u.x_ap_paterno) AS ciudadano,
                                                            COALESCE(c.x_corte, 'Sin corte') AS corte
                                                     FROM solicitudes_respuestas sr
                                                     INNER JOIN solicitudes s ON sr.c_solicitud = s.c_solicitud
                                                     INNER JOIN usuarios u ON s.c_usuario = u.c_usuario
                                                     LEFT JOIN solicitudes_ubicaciones su ON sr.c_solicitud_ubicacion = su.c_solicitud_ubicacion
                                                     LEFT JOIN cortes_nacionales c ON su.c_corte = c.c_corte
                                                     WHERE sr.c_solicitud = :solicitud
                                                       AND sr.c_solicitud_respuesta = :respuesta
                                                       AND sr.l_estado = 'S'
                                                     LIMIT 1");
            $stmt->execute([
                'solicitud' => (int) $matches[1],
                'respuesta' => (int) $matches[2],
            ]);
            $data = $stmt->fetch();
        }

        header('Content-Type: text/html; charset=utf-8');
        echo '<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
        echo '<title>Verificacion de documento</title><style>body{font-family:Arial,sans-serif;background:#eef2f6;margin:0;padding:40px;color:#0b1720}.card{max-width:620px;margin:auto;background:#fff;border-radius:10px;padding:28px;box-shadow:0 10px 30px rgba(8,45,92,.12)}h1{color:#082d5c;margin-top:0}.ok{color:#087a43;font-weight:700}.bad{color:#b42318;font-weight:700}.row{border-top:1px solid #d9e0e8;padding:10px 0}</style></head><body><div class="card">';
        echo '<h1>Verificacion de documento</h1>';

        if ($data) {
            echo '<p class="ok">Documento firmado verificado correctamente.</p>';
            echo '<div class="row"><strong>Codigo:</strong> ' . htmlspecialchars($code, ENT_QUOTES, 'UTF-8') . '</div>';
            echo '<div class="row"><strong>Solicitud:</strong> #' . (int) $data['c_solicitud'] . '</div>';
            echo '<div class="row"><strong>Respuesta:</strong> #' . (int) $data['c_solicitud_respuesta'] . '</div>';
            echo '<div class="row"><strong>Ciudadano:</strong> ' . htmlspecialchars($data['ciudadano'], ENT_QUOTES, 'UTF-8') . '</div>';
            echo '<div class="row"><strong>Corte:</strong> ' . htmlspecialchars($data['corte'], ENT_QUOTES, 'UTF-8') . '</div>';
            echo '<div class="row"><strong>Documento:</strong> ' . htmlspecialchars($data['x_archivo'], ENT_QUOTES, 'UTF-8') . '</div>';
            echo '<div class="row"><strong>Fecha:</strong> ' . htmlspecialchars((string) $data['f_registro'], ENT_QUOTES, 'UTF-8') . '</div>';
        } else {
            echo '<p class="bad">No se encontro un documento firmado con este codigo.</p>';
            echo '<div class="row"><strong>Codigo consultado:</strong> ' . htmlspecialchars($code, ENT_QUOTES, 'UTF-8') . '</div>';
        }

        echo '</div></body></html>';
        exit;
    }

    public function downloadTemplate(): void
    {
        $this->requireAuth();

        $perfil = $_SESSION['id_perfil'] ?? '';
        if (!in_array($perfil, ['03', '04', '10'], true)) {
            $this->redirect('/dashboard');
        }

        $tipo = $_GET['tipo'] ?? 'respuesta';
        $templates = [
            'respuesta' => [
                'file' => 'plantilla_respuesta_transparencia.doc',
                'title' => 'Plantilla de Respuesta de Transparencia',
                'body' => [
                    'Asunto: Atencion de solicitud de acceso a la informacion publica',
                    'Referencia: Solicitud Nro. __________',
                    'Se cumple con remitir la informacion solicitada por el ciudadano, conforme a la documentacion ubicada y validada por el area competente.',
                    'Atentamente,',
                    'Jefatura Administrativa',
                ],
            ],
            'informe' => [
                'file' => 'plantilla_informe_atencion.doc',
                'title' => 'Plantilla de Informe de Atencion',
                'body' => [
                    'Informe Nro. __________',
                    'Materia: Evaluacion y atencion de solicitud de transparencia',
                    'Antecedentes:',
                    'Analisis:',
                    'Conclusion:',
                    'Se recomienda remitir la documentacion adjunta al ciudadano solicitante.',
                ],
            ],
            'observacion' => [
                'file' => 'plantilla_observacion_subsanacion.doc',
                'title' => 'Plantilla de Observacion o Subsanacion',
                'body' => [
                    'Se comunica al ciudadano que el documento presentado requiere subsanacion.',
                    'Motivo de observacion: ______________________________',
                    'Documento requerido: _______________________________',
                    'Plazo de subsanacion: ______________________________',
                ],
            ],
        ];

        $template = $templates[$tipo] ?? $templates['respuesta'];
        $html = '<html><head><meta charset="utf-8"></head><body>';
        $html .= '<h2>' . htmlspecialchars($template['title'], ENT_QUOTES, 'UTF-8') . '</h2>';
        foreach ($template['body'] as $line) {
            $html .= '<p>' . htmlspecialchars($line, ENT_QUOTES, 'UTF-8') . '</p>';
        }
        $html .= '</body></html>';

        header('Content-Type: application/msword; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $template['file'] . '"');
        echo $html;
        exit;
    }

    public function updateSupportSla(): void
    {
        $this->requireAuth();
        $this->ensureSupportTable();
        $this->ensureSupportMessagesTable();

        if (($_SESSION['id_perfil'] ?? '') !== '10') {
            $this->redirect('/dashboard');
        }

        $codigo = (int) ($_POST['c_solicitud_apoyo'] ?? 0);
        $estado = trim($_POST['x_estado'] ?? '');
        $observacion = trim($_POST['x_observacion'] ?? '');
        $mensaje = trim($_POST['x_mensaje'] ?? '');
        $validStates = ['PENDIENTE', 'EN ATENCION', 'RESUELTO', 'CERRADO'];

        if ($codigo <= 0 || !in_array($estado, $validStates, true)) {
            $this->redirect('/modulos/soporte-sla?error=estado');
        }

        $nota = $observacion !== ''
            ? "\n[" . date('Y-m-d H:i') . ' - ' . ($_SESSION['nombre_usuario'] ?? 'ADMIN') . "] " . $observacion
            : '';

        $sql = "UPDATE solicitudes_apoyo
                SET x_estado = :estado,
                    x_descripcion = CONCAT(COALESCE(x_descripcion, ''), :nota),
                    c_aud = :auditoria,
                    f_aud = CURRENT_TIMESTAMP(6),
                    b_aud = 'U',
                    n_aud_ip = :ip
                WHERE c_solicitud_apoyo = :codigo";

        Database::connection()->prepare($sql)->execute([
            'estado' => $estado,
            'nota' => $nota,
            'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
            'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
            'codigo' => $codigo,
        ]);

        $stmt = Database::connection()->prepare("SELECT c_solicitud
                                                 FROM solicitudes_apoyo
                                                 WHERE c_solicitud_apoyo = :codigo
                                                 LIMIT 1");
        $stmt->execute(['codigo' => $codigo]);
        $solicitudId = (int) $stmt->fetchColumn();

        if ($mensaje !== '') {
            if ($solicitudId > 0) {
                Database::connection()->prepare("INSERT INTO solicitudes_apoyo_mensajes (
                                                     c_solicitud_apoyo, c_solicitud, c_usuario,
                                                     x_origen, x_mensaje, l_estado, c_aud, b_aud, n_aud_ip
                                                 ) VALUES (
                                                     :ticket, :solicitud, :usuario,
                                                     'ADMIN', :mensaje, 'S', :auditoria, 'I', :ip
                                                 )")->execute([
                    'ticket' => $codigo,
                    'solicitud' => $solicitudId,
                    'usuario' => (int) ($_SESSION['id_usuario'] ?? 0),
                    'mensaje' => $mensaje,
                    'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
                    'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
                ]);
            }
        }

        AuditLogger::record(
            'INCIDENCIA Y ATENCION SLA',
            'SOPORTE SLA',
            'ACTUALIZACION DE ESTADO',
            $solicitudId > 0 ? $solicitudId : null,
            'Ticket #' . $codigo . ' | Estado: ' . $estado . ($observacion !== '' ? ' | ' . $observacion : '')
        );

        $this->redirect('/modulos/soporte-sla?msg=estado');
    }

    public function supportMessage(): void
    {
        $this->requireAuth();
        $this->ensureSupportTable();
        $this->ensureSupportMessagesTable();

        if (($_SESSION['id_perfil'] ?? '') !== '10') {
            $this->redirect('/dashboard');
        }

        $ticketId = (int) ($_POST['c_solicitud_apoyo'] ?? 0);
        $mensaje = trim($_POST['x_mensaje'] ?? '');

        if ($ticketId <= 0 || $mensaje === '') {
            if ($this->expectsJson()) {
                $this->json(['ok' => false, 'message' => 'Mensaje vacio o ticket invalido.'], 422);
                return;
            }
            $this->redirect('/modulos/soporte-sla?error=estado');
        }

        $stmt = Database::connection()->prepare("SELECT c_solicitud
                                                 FROM solicitudes_apoyo
                                                 WHERE c_solicitud_apoyo = :ticket
                                                   AND l_estado = 'S'
                                                 LIMIT 1");
        $stmt->execute(['ticket' => $ticketId]);
        $solicitudId = (int) $stmt->fetchColumn();

        if ($solicitudId <= 0) {
            if ($this->expectsJson()) {
                $this->json(['ok' => false, 'message' => 'Ticket no encontrado.'], 404);
                return;
            }
            $this->redirect('/modulos/soporte-sla?error=estado');
        }

        Database::connection()->prepare("INSERT INTO solicitudes_apoyo_mensajes (
                                             c_solicitud_apoyo, c_solicitud, c_usuario,
                                             x_origen, x_mensaje, l_estado, c_aud, b_aud, n_aud_ip
                                         ) VALUES (
                                             :ticket, :solicitud, :usuario,
                                             'ADMIN', :mensaje, 'S', :auditoria, 'I', :ip
                                         )")->execute([
            'ticket' => $ticketId,
            'solicitud' => $solicitudId,
            'usuario' => (int) ($_SESSION['id_usuario'] ?? 0),
            'mensaje' => $mensaje,
            'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
            'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
        ]);

        Database::connection()->prepare("UPDATE solicitudes_apoyo
                                         SET x_estado = CASE WHEN x_estado = 'PENDIENTE' THEN 'EN ATENCION' ELSE x_estado END,
                                             c_aud = :auditoria,
                                             f_aud = CURRENT_TIMESTAMP(6),
                                             b_aud = 'U',
                                             n_aud_ip = :ip
                                         WHERE c_solicitud_apoyo = :ticket")
            ->execute([
                'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
                'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
                'ticket' => $ticketId,
            ]);

        AuditLogger::record(
            'INCIDENCIA Y ATENCION SLA',
            'CHAT SOPORTE',
            'MENSAJE DEL ADMINISTRADOR',
            $solicitudId,
            'Ticket #' . $ticketId . ' | ' . $mensaje
        );

        if ($this->expectsJson()) {
            $this->json(['ok' => true, 'messages' => $this->supportMessagesForTicket($ticketId)]);
            return;
        }

        $this->redirect('/modulos/soporte-sla?msg=chat');
    }

    public function supportMessagesJson(): void
    {
        $this->requireAuth();
        $this->ensureSupportMessagesTable();

        if (($_SESSION['id_perfil'] ?? '') !== '10') {
            $this->json(['ok' => false, 'message' => 'No autorizado.'], 403);
            return;
        }

        $ticketId = (int) ($_GET['ticket'] ?? 0);
        if ($ticketId <= 0) {
            $this->json(['ok' => false, 'message' => 'Ticket invalido.'], 422);
            return;
        }

        $this->json(['ok' => true, 'messages' => $this->supportMessagesForTicket($ticketId)]);
    }

    public function uploadSignature(): void
    {
        $this->requireAuth();
        $this->ensureFirmasTable();

        $perfil = $_SESSION['id_perfil'] ?? '';
        if (!in_array($perfil, ['03', '10'], true)) {
            $this->redirect('/dashboard');
        }

        $corte = trim($_POST['c_corte'] ?? '');
        $juez = trim($_POST['x_juez'] ?? '');
        $cargo = trim($_POST['x_cargo'] ?? 'Juez Superior');

        if ($corte === '' || $juez === '' || !isset($_FILES['firma']) || $_FILES['firma']['error'] !== UPLOAD_ERR_OK) {
            $this->redirect('/modulos/supervision?error=firma_jefatura');
        }

        $targetDir = dirname(__DIR__, 2) . '/storage/uploads/firmas/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $original = basename($_FILES['firma']['name']);
        $extension = strtolower(pathinfo($original, PATHINFO_EXTENSION) ?: 'png');
        $archivoSistema = 'FIRMA_JEFE_' . (int) ($_SESSION['id_usuario'] ?? 0) . '_' . time() . '.' . $extension;
        $rutaFisica = $targetDir . $archivoSistema;

        if (!move_uploaded_file($_FILES['firma']['tmp_name'], $rutaFisica)) {
            $this->redirect('/modulos/supervision?error=firma_jefatura');
        }

        $sql = "INSERT INTO firmas_jefes (
                    c_usuario, c_corte, x_juez, x_cargo, x_archivo, x_ubicacion,
                    l_estado, c_aud, b_aud, n_aud_ip
                ) VALUES (
                    :usuario, :corte, :juez, :cargo, :archivo, :ubicacion,
                    'S', :auditoria, 'I', :ip
                )";

        Database::connection()->prepare($sql)->execute([
            'usuario' => (int) ($_SESSION['id_usuario'] ?? 0),
            'corte' => $corte,
            'juez' => mb_strtoupper($juez, 'UTF-8'),
            'cargo' => mb_strtoupper($cargo, 'UTF-8'),
            'archivo' => substr($original, 0, 100),
            'ubicacion' => 'uploads/firmas/' . $archivoSistema,
            'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
            'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
        ]);

        $this->redirect('/modulos/supervision?msg=firma_jefatura');
    }

    public function updateSignature(): void
    {
        $this->requireAuth();
        $this->ensureFirmasTable();

        $perfil = $_SESSION['id_perfil'] ?? '';
        if (!in_array($perfil, ['03', '10'], true)) {
            $this->redirect('/dashboard');
        }

        $firmaId = (int) ($_POST['c_firma_jefe'] ?? 0);
        $corte = trim($_POST['c_corte'] ?? '');
        $juez = trim($_POST['x_juez'] ?? '');
        $cargo = trim($_POST['x_cargo'] ?? '');

        if ($firmaId <= 0 || $corte === '' || $juez === '' || $cargo === '') {
            $this->redirect('/modulos/supervision?error=firma_jefatura');
        }

        $firma = $this->firmaEditable($firmaId);
        if (!$firma) {
            $this->redirect('/modulos/supervision?error=firma_jefatura');
        }

        $archivo = $firma['x_archivo'];
        $ubicacion = $firma['x_ubicacion'];

        if (isset($_FILES['firma']) && $_FILES['firma']['error'] === UPLOAD_ERR_OK && $_FILES['firma']['name'] !== '') {
            $targetDir = dirname(__DIR__, 2) . '/storage/uploads/firmas/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $archivo = basename($_FILES['firma']['name']);
            $extension = strtolower(pathinfo($archivo, PATHINFO_EXTENSION) ?: 'png');
            $archivoSistema = 'FIRMA_JEFE_' . (int) ($_SESSION['id_usuario'] ?? 0) . '_' . time() . '.' . $extension;
            $rutaFisica = $targetDir . $archivoSistema;

            if (move_uploaded_file($_FILES['firma']['tmp_name'], $rutaFisica)) {
                $ubicacion = 'uploads/firmas/' . $archivoSistema;
            }
        }

        $sql = "UPDATE firmas_jefes
                SET c_corte = :corte,
                    x_juez = :juez,
                    x_cargo = :cargo,
                    x_archivo = :archivo,
                    x_ubicacion = :ubicacion,
                    c_aud = :auditoria,
                    f_aud = CURRENT_TIMESTAMP(6),
                    b_aud = 'U',
                    n_aud_ip = :ip
                WHERE c_firma_jefe = :firma";

        Database::connection()->prepare($sql)->execute([
            'corte' => $corte,
            'juez' => mb_strtoupper($juez, 'UTF-8'),
            'cargo' => mb_strtoupper($cargo, 'UTF-8'),
            'archivo' => substr($archivo, 0, 100),
            'ubicacion' => substr($ubicacion, 0, 100),
            'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
            'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
            'firma' => $firmaId,
        ]);

        $this->redirect('/modulos/supervision?msg=firma_actualizada');
    }

    public function deleteSignature(): void
    {
        $this->requireAuth();
        $this->ensureFirmasTable();

        $perfil = $_SESSION['id_perfil'] ?? '';
        if (!in_array($perfil, ['03', '10'], true)) {
            $this->redirect('/dashboard');
        }

        $firmaId = (int) ($_POST['c_firma_jefe'] ?? 0);
        $firma = $this->firmaEditable($firmaId);
        if (!$firma) {
            $this->redirect('/modulos/supervision?error=firma_jefatura');
        }

        $sql = "UPDATE firmas_jefes
                SET l_estado = 'N',
                    c_aud = :auditoria,
                    f_aud = CURRENT_TIMESTAMP(6),
                    b_aud = 'D',
                    n_aud_ip = :ip
                WHERE c_firma_jefe = :firma";

        Database::connection()->prepare($sql)->execute([
            'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
            'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
            'firma' => $firmaId,
        ]);

        $this->redirect('/modulos/supervision?msg=firma_eliminada');
    }

    public function signatureFile(): void
    {
        $this->requireAuth();
        $this->ensureFirmasTable();

        $firmaId = (int) ($_GET['id'] ?? 0);
        $stmt = Database::connection()->prepare("SELECT * FROM firmas_jefes WHERE c_firma_jefe = :id AND l_estado = 'S'");
        $stmt->execute(['id' => $firmaId]);
        $firma = $stmt->fetch();

        if (!$firma) {
            http_response_code(404);
            echo 'Firma no encontrada.';
            return;
        }

        $path = dirname(__DIR__, 2) . '/storage/' . ltrim($firma['x_ubicacion'], '/');
        if (!is_file($path)) {
            http_response_code(404);
            echo 'Archivo fisico no encontrado.';
            return;
        }

        $extension = strtolower(pathinfo($firma['x_archivo'], PATHINFO_EXTENSION));
        $mime = match ($extension) {
            'pdf' => 'application/pdf',
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'svg' => 'image/svg+xml',
            default => 'application/octet-stream',
        };

        header('Content-Type: ' . $mime);
        header('Content-Disposition: inline; filename="' . basename($firma['x_archivo']) . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }

    private function rowsFor(string $slug): array
    {
        return match ($slug) {
            'bandeja-entrada' => $this->bandejaEntrada(),
            'derivar-expedientes' => $this->solicitudesPorDestino(['DERIVADO A:']),
            'supervision', 'reportes' => $this->solicitudesPorDestino(['SECRETARIA GENERAL', 'ADMINISTRACION DE CORTE']),
            'actualizar-estados', 'adjuntar-documentos' => $this->solicitudesPorDestino([
                'SECRETARIA GENERAL',
                'ASISTENCIA ADMINISTRATIVA',
                'ARCHIVO CENTRAL | DOCUMENTACION REMITIDA A',
            ]),
            'busqueda-documental', 'preparar-anexos' => $this->solicitudesPorDestino(['ARCHIVO CENTRAL']),
            'alertas-sla', 'auditoria', 'analisis-sla', 'incumplimientos' => $this->solicitudesPorDestino(['ODANC']),
            'validar-ingresos', 'remitir-solicitudes' => $this->solicitudesPorDestino(['MESA DE PARTES']),
            'indicadores', 'coordinacion' => $this->solicitudesPorDestino(['DERIVADO A:']),
            'usuarios' => $this->usuarios(),
            'perfiles' => $this->perfiles(),
            'catalogos' => $this->catalogos(),
            'soporte-sla' => $this->soporteSla(),
            'pagos-culqi' => $this->pagosCulqi(),
            'auditoria-sistema' => $this->auditoriaSistema(),
            default => $this->solicitudesResumen(),
        };
    }

    private function canAccessModule(string $perfil, string $slug, array $module): bool
    {
        if ($perfil === '10' || $perfil === $module['perfil']) {
            return true;
        }

        return $perfil === '03' && in_array($slug, ['actualizar-estados', 'adjuntar-documentos'], true);
    }

    private function usuarios(): array
    {
        $sql = "SELECT u.c_usuario AS Codigo,
                       CONCAT(u.x_nombres, ' ', u.x_ap_paterno) AS Usuario,
                       u.x_correo AS Correo,
                       p.x_tipo_perfil AS Perfil,
                       u.l_estado AS Estado
                FROM usuarios u
                INNER JOIN tipos_perfiles p ON u.c_tipo_perfil = p.c_tipo_perfil
                ORDER BY u.c_usuario";

        return Database::connection()->query($sql)->fetchAll();
    }

    private function perfiles(): array
    {
        return Database::connection()
            ->query("SELECT c_tipo_perfil AS Codigo, x_tipo_perfil AS Perfil, l_estado AS Estado, f_registro AS Registro FROM tipos_perfiles ORDER BY c_tipo_perfil")
            ->fetchAll();
    }

    private function catalogos(): array
    {
        $tables = [
            'tipos_perfiles' => 'Tipos de perfil',
            'tipos_personas' => 'Tipos de persona',
            'cortes_nacionales' => 'Cortes nacionales',
            'departamentos' => 'Departamentos',
            'provincias' => 'Provincias',
            'distritos' => 'Distritos',
            'tipos_vias' => 'Tipos de vias',
            'tipos_zonas' => 'Tipos de zonas',
        ];

        $rows = [];
        foreach ($tables as $table => $label) {
            $count = Database::connection()->query("SELECT COUNT(*) FROM {$table}")->fetchColumn();
            $rows[] = ['Catalogo' => $label, 'Tabla' => $table, 'Registros' => $count];
        }

        return $rows;
    }

    private function soporteSla(): array
    {
        $this->ensureSupportTable();
        $this->ensureSupportMessagesTable();

        $sql = "SELECT a.c_solicitud_apoyo AS Codigo,
                       a.c_solicitud AS Solicitud,
                       CONCAT(u.x_nombres, ' ', u.x_ap_paterno) AS Reporta,
                       COALESCE(sa.x_archivo, 'Sin anexo') AS Documento,
                       a.x_motivo AS Motivo,
                       a.x_estado AS Estado,
                       COALESCE(ultimo.ultimo_mensaje, 'Sin mensajes') AS `Ultimo mensaje`,
                       a.x_descripcion AS _Descripcion,
                       COALESCE(chat.mensajes, '') AS _Mensajes,
                       COALESCE(chat.total, 0) AS Chat,
                       TIMESTAMPDIFF(HOUR, a.f_registro, NOW()) AS Horas,
                       CASE
                           WHEN TIMESTAMPDIFF(HOUR, a.f_registro, NOW()) > a.n_sla_horas THEN 'VENCIDO'
                           ELSE 'EN SLA'
                       END AS SLA,
                       a.f_registro AS Registro
                FROM solicitudes_apoyo a
                LEFT JOIN usuarios u ON a.c_usuario_reporta = u.c_usuario
                LEFT JOIN solicitudes_anexos sa ON a.c_solicitud_anexo = sa.c_solicitud_anexo
                LEFT JOIN (
                    SELECT c_solicitud_apoyo,
                           COUNT(*) AS total,
                           GROUP_CONCAT(CONCAT(DATE_FORMAT(f_registro, '%d/%m %H:%i'), ' | ', x_origen, ': ', x_mensaje) ORDER BY f_registro, c_mensaje SEPARATOR '\n') AS mensajes
                    FROM solicitudes_apoyo_mensajes
                    WHERE l_estado = 'S'
                    GROUP BY c_solicitud_apoyo
                ) chat ON a.c_solicitud_apoyo = chat.c_solicitud_apoyo
                LEFT JOIN (
                    SELECT m.c_solicitud_apoyo,
                           CONCAT(m.x_origen, ': ', LEFT(m.x_mensaje, 90)) AS ultimo_mensaje
                    FROM solicitudes_apoyo_mensajes m
                    INNER JOIN (
                        SELECT c_solicitud_apoyo, MAX(c_mensaje) AS ultimo
                        FROM solicitudes_apoyo_mensajes
                        WHERE l_estado = 'S'
                        GROUP BY c_solicitud_apoyo
                    ) ult ON m.c_solicitud_apoyo = ult.c_solicitud_apoyo AND m.c_mensaje = ult.ultimo
                ) ultimo ON a.c_solicitud_apoyo = ultimo.c_solicitud_apoyo
                WHERE a.l_estado = 'S'
                ORDER BY a.f_registro DESC";

        return Database::connection()->query($sql)->fetchAll();
    }

    private function pagosCulqi(): array
    {
        $this->ensureReproductionPaymentsTable();

        $sql = "SELECT p.c_pago_reproduccion AS _PagoId,
                       p.c_pago_reproduccion AS Codigo,
                       p.c_solicitud AS Solicitud,
                       CONCAT(u.x_nombres, ' ', u.x_ap_paterno) AS Ciudadano,
                       p.x_tipo_copia AS Tipo,
                       CONCAT(p.x_moneda, ' ', FORMAT(p.n_monto, 2)) AS Monto,
                       p.x_pasarela AS Pasarela,
                       p.x_codigo_pago AS `Codigo Culqi`,
                       p.x_estado AS Estado,
                       p.x_estado_entrega AS Entrega,
                       COALESCE(p.x_copia_archivo, '') AS Copia,
                       p.f_registro AS Fecha
                FROM pagos_reproduccion p
                INNER JOIN solicitudes s ON p.c_solicitud = s.c_solicitud
                INNER JOIN usuarios u ON s.c_usuario = u.c_usuario
                WHERE p.l_estado = 'S'
                ORDER BY p.f_registro DESC";

        return Database::connection()->query($sql)->fetchAll();
    }

    private function auditoriaSistema(): array
    {
        AuditLogger::ensureTable();
        $this->seedAuditFromExistingTrace();
        AuditLogger::record(
            'CONSULTA DE AUDITORIA',
            'REGISTRO AUDITORIA',
            'VISUALIZACION DEL LOG DE AUDITORIA',
            null,
            'Administrador consulta los eventos criticos del sistema.'
        );

        $sql = "SELECT a.c_auditoria AS Codigo,
                       a.f_registro AS Fecha,
                       COALESCE(CONCAT(u.x_nombres, ' ', u.x_ap_paterno), 'SISTEMA') AS Usuario,
                       COALESCE(tp.x_tipo_perfil, '-') AS Perfil,
                       COALESCE(a.c_solicitud, '-') AS Solicitud,
                       a.x_evento AS Evento,
                       a.x_modulo AS Modulo,
                       a.x_accion AS Accion,
                       LEFT(COALESCE(a.x_detalle, ''), 180) AS Detalle,
                       a.n_ip AS IP
                FROM auditorias_sistema a
                LEFT JOIN usuarios u ON a.c_usuario = u.c_usuario
                LEFT JOIN tipos_perfiles tp ON u.c_tipo_perfil = tp.c_tipo_perfil
                WHERE a.l_estado = 'S'
                ORDER BY a.f_registro DESC
                LIMIT 100";

        return Database::connection()->query($sql)->fetchAll();
    }

    private function seedAuditFromExistingTrace(): void
    {
        $pdo = Database::connection();
        $hasRows = (int) $pdo->query("SELECT COUNT(*) FROM auditorias_sistema")->fetchColumn();
        if ($hasRows > 0) {
            return;
        }

        $pdo->exec("INSERT INTO auditorias_sistema (
                        c_usuario, c_solicitud, f_registro, x_evento, x_modulo, x_accion,
                        x_detalle, n_ip, x_user_agent, l_estado
                    )
                    SELECT su.c_usuario,
                           su.c_solicitud,
                           su.f_registro,
                           CASE
                               WHEN UPPER(su.x_observacion) LIKE '%REGISTRO INICIAL%' THEN 'PRESENTACION DE SOLICITUD'
                               WHEN UPPER(su.x_observacion) LIKE '%VALIDADO POR MESA DE PARTES%' THEN 'VALIDACION Y CARGO'
                               WHEN UPPER(su.x_observacion) LIKE '%REMITIDO POR MESA DE PARTES%' THEN 'ASIGNACION Y VALIDACION'
                               WHEN UPPER(su.x_observacion) LIKE '%DERIVADO A:%' THEN 'ASIGNACION Y VALIDACION'
                               WHEN UPPER(su.x_observacion) LIKE '%ARCHIVO CENTRAL%' THEN 'ATENCION DE SOLICITUD'
                               WHEN UPPER(su.x_observacion) LIKE '%FIRMA DIGITAL%' THEN 'GENERACION DE CARGO'
                               WHEN UPPER(su.x_observacion) LIKE '%PAGO DE REPRODUCCION%' THEN 'PAGO DE REPRODUCCION'
                               WHEN UPPER(su.x_observacion) LIKE '%COPIA%' THEN 'COPIA ENTREGADA'
                               ELSE 'MOVIMIENTO DE SOLICITUD'
                           END,
                           CASE
                               WHEN UPPER(su.x_observacion) LIKE '%MESA DE PARTES%' THEN 'MESA DE PARTES'
                               WHEN UPPER(su.x_observacion) LIKE '%ARCHIVO CENTRAL%' THEN 'ARCHIVO CENTRAL'
                               WHEN UPPER(su.x_observacion) LIKE '%FIRMA DIGITAL%' THEN 'ASISTENCIA ADMINISTRATIVA'
                               WHEN UPPER(su.x_observacion) LIKE '%PAGO DE REPRODUCCION%' THEN 'CULQI ONLINE DEMO'
                               WHEN UPPER(su.x_observacion) LIKE '%COPIA%' THEN 'PAGOS CULQI'
                               WHEN UPPER(su.x_observacion) LIKE '%DERIVADO A:%' THEN 'TRANSPARENCIA'
                               ELSE 'CASILLERO DIGITAL'
                           END,
                           CASE
                               WHEN UPPER(su.x_observacion) LIKE '%REGISTRO INICIAL%' THEN 'REGISTRO DE SOLICITUD'
                               WHEN UPPER(su.x_observacion) LIKE '%VALIDADO POR MESA DE PARTES%' THEN 'VALIDACION DE INGRESO'
                               WHEN UPPER(su.x_observacion) LIKE '%REMITIDO POR MESA DE PARTES%' THEN 'REMISION DE SOLICITUD'
                               WHEN UPPER(su.x_observacion) LIKE '%DERIVADO A:%' THEN 'DERIVACION DE DOCUMENTOS'
                               WHEN UPPER(su.x_observacion) LIKE '%ARCHIVO CENTRAL%' THEN 'ATENCION DOCUMENTAL'
                               WHEN UPPER(su.x_observacion) LIKE '%FIRMA DIGITAL%' THEN 'RESPUESTA FIRMADA GENERADA'
                               WHEN UPPER(su.x_observacion) LIKE '%PAGO DE REPRODUCCION%' THEN 'PAGO REGISTRADO'
                               WHEN UPPER(su.x_observacion) LIKE '%COPIA%' THEN 'GESTION DE COPIA'
                               ELSE 'MOVIMIENTO REGISTRADO'
                           END,
                           su.x_observacion,
                           su.n_aud_ip,
                           'CARGA INICIAL DESDE TRAZABILIDAD',
                           'S'
                    FROM solicitudes_ubicaciones su
                    WHERE su.l_estado = 'S'");

        $pdo->exec("INSERT INTO auditorias_sistema (
                        c_usuario, c_solicitud, f_registro, x_evento, x_modulo, x_accion,
                        x_detalle, n_ip, x_user_agent, l_estado
                    )
                    SELECT sr.c_aud,
                           sr.c_solicitud,
                           sr.f_registro,
                           'NOTIFICACION ENVIADA',
                           'CASILLERO DIGITAL',
                           'RESPUESTA DISPONIBLE PARA EL CIUDADANO',
                           CONCAT('Respuesta firmada: ', sr.x_archivo),
                           sr.n_aud_ip,
                           'CARGA INICIAL DESDE RESPUESTAS',
                           'S'
                    FROM solicitudes_respuestas sr
                    WHERE sr.l_estado = 'S'");

        $this->ensureSupportTable();
        $pdo->exec("INSERT INTO auditorias_sistema (
                        c_usuario, c_solicitud, f_registro, x_evento, x_modulo, x_accion,
                        x_detalle, n_ip, x_user_agent, l_estado
                    )
                    SELECT a.c_usuario_reporta,
                           a.c_solicitud,
                           a.f_registro,
                           'INCIDENCIA Y ATENCION SLA',
                           'SOPORTE SLA',
                           'REGISTRO DE INCIDENCIA',
                           CONCAT(a.x_motivo, ' | ', COALESCE(a.x_descripcion, '')),
                           a.n_aud_ip,
                           'CARGA INICIAL DESDE SOPORTE',
                           'S'
                    FROM solicitudes_apoyo a
                    WHERE a.l_estado = 'S'");

        $this->ensureReproductionPaymentsTable();
        $pdo->exec("INSERT INTO auditorias_sistema (
                        c_usuario, c_solicitud, f_registro, x_evento, x_modulo, x_accion,
                        x_detalle, n_ip, x_user_agent, l_estado
                    )
                    SELECT p.c_usuario,
                           p.c_solicitud,
                           p.f_registro,
                           'PAGO DE REPRODUCCION',
                           'CULQI ONLINE DEMO',
                           'PAGO REGISTRADO',
                           CONCAT(p.x_tipo_copia, ' | ', p.x_moneda, ' ', p.n_monto, ' | ', p.x_codigo_pago),
                           p.n_aud_ip,
                           'CARGA INICIAL DESDE PAGOS',
                           'S'
                    FROM pagos_reproduccion p
                    WHERE p.l_estado = 'S'");
    }

    private function documentosFirmados(): array
    {
        $this->ensureResponseSignaturesTable();

        $sql = "SELECT sr.c_solicitud_respuesta AS _respuesta_id,
                       sr.c_solicitud AS Solicitud,
                       CONCAT(u.x_nombres, ' ', u.x_ap_paterno) AS Ciudadano,
                       COALESCE(c.x_corte, 'Sin corte') AS Corte,
                       fj.x_juez AS Juez,
                       fj.x_cargo AS Cargo,
                       sr.x_archivo AS Documento,
                       sr.f_registro AS Fecha
                FROM solicitudes_respuestas sr
                INNER JOIN solicitudes s ON sr.c_solicitud = s.c_solicitud
                INNER JOIN usuarios u ON s.c_usuario = u.c_usuario
                INNER JOIN solicitudes_ubicaciones su ON sr.c_solicitud_ubicacion = su.c_solicitud_ubicacion
                LEFT JOIN cortes_nacionales c ON su.c_corte = c.c_corte
                LEFT JOIN solicitudes_respuestas_firmas srf ON sr.c_solicitud_respuesta = srf.c_solicitud_respuesta AND srf.l_estado = 'S'
                LEFT JOIN firmas_jefes fj ON srf.c_firma_jefe = fj.c_firma_jefe
                WHERE sr.l_estado = 'S'
                ORDER BY sr.f_registro DESC";

        return Database::connection()->query($sql)->fetchAll();
    }

    private function reportStats(): array
    {
        $this->ensureSupportTable();

        $pdo = Database::connection();
        $latest = "SELECT su.*
                   FROM solicitudes_ubicaciones su
                   INNER JOIN (
                       SELECT c_solicitud, MAX(c_solicitud_ubicacion) AS ultimo
                       FROM solicitudes_ubicaciones
                       WHERE l_estado = 'S'
                       GROUP BY c_solicitud
                   ) ult ON su.c_solicitud_ubicacion = ult.ultimo";

        return [
            'Total solicitudes' => (int) $pdo->query("SELECT COUNT(*) FROM solicitudes WHERE l_estado = 'S'")->fetchColumn(),
            'En proceso' => (int) $pdo->query("SELECT COUNT(*) FROM ({$latest}) x WHERE x.c_tipo_solicitud_estado = '02'")->fetchColumn(),
            'Atendidas' => (int) $pdo->query("SELECT COUNT(*) FROM ({$latest}) x WHERE x.c_tipo_solicitud_estado = '04'")->fetchColumn(),
            'Vencidas' => (int) $pdo->query("SELECT COUNT(*) FROM ({$latest}) x WHERE x.c_tipo_solicitud_estado = '05'")->fetchColumn(),
            'PDF firmados' => (int) $pdo->query("SELECT COUNT(*) FROM solicitudes_respuestas WHERE l_estado = 'S'")->fetchColumn(),
            'Soporte pendiente' => (int) $pdo->query("SELECT COUNT(*) FROM solicitudes_apoyo WHERE l_estado = 'S' AND x_estado = 'PENDIENTE'")->fetchColumn(),
        ];
    }

    private function reportRows(): array
    {
        $sql = "SELECT s.c_solicitud AS Solicitud,
                       CONCAT(u.x_nombres, ' ', u.x_ap_paterno) AS Ciudadano,
                       COALESCE(c.x_corte, 'Sin corte') AS Corte,
                       COALESCE(e.x_tipo_solicitud_estado, 'Pendiente') AS Estado,
                       su.f_registro AS UltimoMovimiento
                FROM solicitudes s
                INNER JOIN usuarios u ON s.c_usuario = u.c_usuario
                INNER JOIN solicitudes_ubicaciones su ON su.c_solicitud_ubicacion = (
                    SELECT MAX(su2.c_solicitud_ubicacion)
                    FROM solicitudes_ubicaciones su2
                    WHERE su2.c_solicitud = s.c_solicitud AND su2.l_estado = 'S'
                )
                LEFT JOIN cortes_nacionales c ON su.c_corte = c.c_corte
                LEFT JOIN tipos_solicitud_estados e ON su.c_tipo_solicitud_estado = e.c_tipo_solicitud_estado
                WHERE s.l_estado = 'S'
                ORDER BY su.f_registro DESC
                LIMIT 10";

        return Database::connection()->query($sql)->fetchAll();
    }

    private function signedDocumentData(int $respuestaId): ?array
    {
        if ($respuestaId <= 0) {
            $respuestaId = $this->latestSignedResponseId();
        }

        $sql = "SELECT sr.*,
                       sr.c_solicitud_respuesta AS respuesta_id,
                       sr.c_solicitud AS solicitud_id,
                       sr.x_archivo AS documento_archivo,
                       sr.x_ubicacion AS documento_ubicacion,
                       CONCAT(u.x_nombres, ' ', u.x_ap_paterno) AS ciudadano,
                       COALESCE(c.x_corte, 'Sin corte') AS corte,
                       srf.c_firma_jefe,
                       fj.x_juez,
                       fj.x_cargo,
                       fj.x_archivo AS firma_archivo,
                       fj.x_ubicacion AS firma_ubicacion,
                       su.x_observacion
                FROM solicitudes_respuestas sr
                INNER JOIN solicitudes s ON sr.c_solicitud = s.c_solicitud
                INNER JOIN usuarios u ON s.c_usuario = u.c_usuario
                INNER JOIN solicitudes_ubicaciones su ON sr.c_solicitud_ubicacion = su.c_solicitud_ubicacion
                LEFT JOIN cortes_nacionales c ON su.c_corte = c.c_corte
                LEFT JOIN solicitudes_respuestas_firmas srf ON sr.c_solicitud_respuesta = srf.c_solicitud_respuesta AND srf.l_estado = 'S'
                LEFT JOIN firmas_jefes fj ON srf.c_firma_jefe = fj.c_firma_jefe
                WHERE sr.c_solicitud_respuesta = :respuesta
                  AND sr.l_estado = 'S'
                LIMIT 1";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['respuesta' => $respuestaId]);
        $data = $stmt->fetch();

        if ($data) {
            $path = dirname(__DIR__, 2) . '/storage/' . ltrim((string) ($data['documento_ubicacion'] ?? ''), '/');
            $data['documento_existe'] = is_file($path) ? 'S' : 'N';
        }

        return $data ?: null;
    }

    private function generateSignedPdf(int $respuestaId): void
    {
        if ($respuestaId <= 0) {
            return;
        }

        $sql = "SELECT sr.c_solicitud_respuesta,
                       sr.x_archivo,
                       sr.x_ubicacion,
                       fj.x_juez,
                       fj.x_cargo,
                       fj.x_ubicacion AS firma_ubicacion
                FROM solicitudes_respuestas sr
                LEFT JOIN solicitudes_respuestas_firmas srf ON sr.c_solicitud_respuesta = srf.c_solicitud_respuesta AND srf.l_estado = 'S'
                LEFT JOIN firmas_jefes fj ON srf.c_firma_jefe = fj.c_firma_jefe
                WHERE sr.c_solicitud_respuesta = :respuesta
                  AND sr.l_estado = 'S'
                LIMIT 1";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['respuesta' => $respuestaId]);
        $row = $stmt->fetch();

        if (!$row || empty($row['firma_ubicacion'])) {
            return;
        }

        $storage = dirname(__DIR__, 2) . '/storage/';
        $inputPath = $storage . ltrim((string) $row['x_ubicacion'], '/');
        if (!is_file($inputPath) || strtolower(pathinfo($inputPath, PATHINFO_EXTENSION)) !== 'pdf') {
            return;
        }

        if (str_starts_with((string) $row['x_ubicacion'], 'uploads/respuestas/firmado_') && is_file($inputPath)) {
            return;
        }

        $signaturePath = $storage . ltrim((string) $row['firma_ubicacion'], '/');
        $outputName = 'firmado_' . $respuestaId . '.pdf';
        $outputRelative = 'uploads/respuestas/' . $outputName;
        $outputPath = $storage . $outputRelative;
        $script = dirname(__DIR__) . '/Support/pdf_signer.py';
        $python = 'C:\\Users\\Jose\\AppData\\Local\\Programs\\Python\\Python39\\python.exe';

        $command = '"' . $python . '" '
            . escapeshellarg($script) . ' '
            . escapeshellarg($inputPath) . ' '
            . escapeshellarg($signaturePath) . ' '
            . escapeshellarg($outputPath) . ' '
            . escapeshellarg((string) ($row['x_juez'] ?? 'FIRMA DIGITAL')) . ' '
            . escapeshellarg((string) ($row['x_cargo'] ?? 'JEFATURA'));

        exec($command, $output, $exitCode);
        if ($exitCode !== 0 || !is_file($outputPath)) {
            return;
        }

        Database::connection()->prepare("UPDATE solicitudes_respuestas
                                         SET x_ubicacion = :ubicacion,
                                             x_archivo = :archivo,
                                             b_aud = 'U',
                                             f_aud = CURRENT_TIMESTAMP(6)
                                         WHERE c_solicitud_respuesta = :respuesta")
            ->execute([
                'ubicacion' => substr($outputRelative, 0, 100),
                'archivo' => substr($outputName, 0, 100),
                'respuesta' => $respuestaId,
            ]);
    }

    private function latestSignedResponseId(): int
    {
        $id = Database::connection()
            ->query("SELECT COALESCE(MAX(c_solicitud_respuesta), 0) FROM solicitudes_respuestas WHERE l_estado = 'S'")
            ->fetchColumn();

        return (int) $id;
    }

    private function cortes(): array
    {
        return Database::connection()
            ->query("SELECT c_corte, x_corte FROM cortes_nacionales WHERE l_estado = 'S' ORDER BY x_corte")
            ->fetchAll();
    }

    private function firmasJefes(bool $ownOnly = false): array
    {
        $this->ensureFirmasTable();

        $sql = "SELECT f.c_firma_jefe,
                       f.c_usuario,
                       f.c_corte,
                       c.x_corte,
                       f.x_juez,
                       f.x_cargo,
                       f.x_archivo,
                       f.x_ubicacion,
                       f.f_registro
                FROM firmas_jefes f
                INNER JOIN cortes_nacionales c ON f.c_corte = c.c_corte
                WHERE f.l_estado = 'S'";

        $params = [];
        if ($ownOnly) {
            $sql .= " AND f.c_usuario = :usuario";
            $params['usuario'] = (int) ($_SESSION['id_usuario'] ?? 0);
        }

        $sql .= " ORDER BY c.x_corte, f.x_juez";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    private function shouldShowOnlyOwnSignatures(string $slug): bool
    {
        return in_array($slug, ['supervision', 'reportes'], true)
            && ($_SESSION['id_perfil'] ?? '') === '03';
    }

    private function canMesaPartesAct(): bool
    {
        return in_array($_SESSION['id_perfil'] ?? '', ['07', '10'], true);
    }

    private function canArchivoAct(): bool
    {
        return in_array($_SESSION['id_perfil'] ?? '', ['06', '10'], true);
    }

    private function insertRequestMovement(int $solicitud, string $corte, string $estado, string $observacion): void
    {
        $sql = "INSERT INTO solicitudes_ubicaciones (
                    c_solicitud, c_usuario, c_tipo_solicitud_estado, c_corte,
                    x_observacion, l_estado, b_aud, c_aud, n_aud_ip
                ) VALUES (
                    :solicitud, :usuario, :estado, :corte,
                    :observacion, 'S', 'I', :auditoria, :ip
                )";

        Database::connection()->prepare($sql)->execute([
            'solicitud' => $solicitud,
            'usuario' => (int) ($_SESSION['id_usuario'] ?? 0),
            'estado' => $estado,
            'corte' => $corte,
            'observacion' => mb_strtoupper($observacion, 'UTF-8'),
            'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
            'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
        ]);
    }

    private function latestMovementStartsWith(int $solicitud, string $prefix): bool
    {
        $stmt = Database::connection()->prepare("SELECT x_observacion
                                                 FROM solicitudes_ubicaciones
                                                 WHERE c_solicitud = :solicitud
                                                   AND l_estado = 'S'
                                                 ORDER BY c_solicitud_ubicacion DESC
                                                 LIMIT 1");
        $stmt->execute(['solicitud' => $solicitud]);
        $latest = (string) ($stmt->fetchColumn() ?: '');

        return str_starts_with(mb_strtoupper($latest, 'UTF-8'), mb_strtoupper($prefix, 'UTF-8'));
    }

    private function ensureArchivoPreparacionesTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS archivo_preparaciones (
                    c_archivo_preparacion BIGINT NOT NULL AUTO_INCREMENT,
                    c_solicitud BIGINT NOT NULL,
                    c_usuario BIGINT,
                    c_corte CHAR(2) NOT NULL,
                    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
                    x_archivo VARCHAR(100) NOT NULL,
                    x_ubicacion VARCHAR(120) NOT NULL,
                    x_observacion TEXT,
                    l_estado CHAR(1) DEFAULT 'S',
                    c_aud INT,
                    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
                    b_aud CHAR(1) NOT NULL,
                    n_aud_ip VARCHAR(15),
                    PRIMARY KEY (c_archivo_preparacion),
                    INDEX idx_archivo_preparaciones_solicitud (c_solicitud)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        Database::connection()->exec($sql);
    }

    private function firmaEditable(int $firmaId): ?array
    {
        if ($firmaId <= 0) {
            return null;
        }

        $sql = "SELECT *
                FROM firmas_jefes
                WHERE c_firma_jefe = :firma
                  AND l_estado = 'S'";

        $params = ['firma' => $firmaId];
        if (($_SESSION['id_perfil'] ?? '') !== '10') {
            $sql .= " AND c_usuario = :usuario";
            $params['usuario'] = (int) ($_SESSION['id_usuario'] ?? 0);
        }

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);
        $firma = $stmt->fetch();

        return $firma ?: null;
    }

    private function ensureFirmasTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS firmas_jefes (
                    c_firma_jefe BIGINT NOT NULL AUTO_INCREMENT,
                    c_usuario BIGINT,
                    c_corte CHAR(2) NOT NULL,
                    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
                    x_juez VARCHAR(120) NOT NULL,
                    x_cargo VARCHAR(80) NOT NULL,
                    x_archivo VARCHAR(100) NOT NULL,
                    x_ubicacion VARCHAR(100) NOT NULL,
                    l_estado CHAR(1) DEFAULT 'S',
                    c_aud INT,
                    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP,
                    b_aud CHAR(1) NOT NULL,
                    n_aud_ip VARCHAR(15),
                    PRIMARY KEY (c_firma_jefe),
                    INDEX idx_firmas_jefes_corte (c_corte)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        Database::connection()->exec($sql);
    }

    private function ensureResponseSignaturesTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS solicitudes_respuestas_firmas (
                    c_respuesta_firma BIGINT NOT NULL AUTO_INCREMENT,
                    c_solicitud_respuesta BIGINT NOT NULL,
                    c_firma_jefe BIGINT NOT NULL,
                    c_usuario_firma BIGINT,
                    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
                    l_estado CHAR(1) DEFAULT 'S',
                    c_aud INT,
                    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
                    b_aud CHAR(1) NOT NULL,
                    n_aud_ip VARCHAR(15),
                    PRIMARY KEY (c_respuesta_firma),
                    INDEX idx_respuestas_firmas_respuesta (c_solicitud_respuesta),
                    INDEX idx_respuestas_firmas_firma (c_firma_jefe)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        Database::connection()->exec($sql);
    }

    private function ensureSupportTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS solicitudes_apoyo (
                    c_solicitud_apoyo BIGINT NOT NULL AUTO_INCREMENT,
                    c_solicitud BIGINT NOT NULL,
                    c_solicitud_anexo BIGINT NULL,
                    c_usuario_reporta BIGINT,
                    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
                    x_motivo VARCHAR(120) NOT NULL,
                    x_descripcion TEXT,
                    x_estado VARCHAR(30) DEFAULT 'PENDIENTE',
                    n_sla_horas INT DEFAULT 24,
                    l_estado CHAR(1) DEFAULT 'S',
                    c_aud INT,
                    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
                    b_aud CHAR(1) NOT NULL,
                    n_aud_ip VARCHAR(15),
                    PRIMARY KEY (c_solicitud_apoyo),
                    INDEX idx_apoyo_solicitud (c_solicitud),
                    INDEX idx_apoyo_estado (x_estado)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        Database::connection()->exec($sql);
    }

    private function ensureSupportMessagesTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS solicitudes_apoyo_mensajes (
                    c_mensaje BIGINT NOT NULL AUTO_INCREMENT,
                    c_solicitud_apoyo BIGINT NULL,
                    c_solicitud BIGINT NOT NULL,
                    c_usuario BIGINT NULL,
                    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
                    x_origen VARCHAR(20) NOT NULL,
                    x_mensaje TEXT NOT NULL,
                    l_estado CHAR(1) DEFAULT 'S',
                    c_aud INT,
                    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
                    b_aud CHAR(1) NOT NULL,
                    n_aud_ip VARCHAR(15),
                    PRIMARY KEY (c_mensaje),
                    INDEX idx_apoyo_mensajes_ticket (c_solicitud_apoyo),
                    INDEX idx_apoyo_mensajes_solicitud (c_solicitud)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        Database::connection()->exec($sql);
    }

    private function ensureReproductionPaymentsTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS pagos_reproduccion (
                    c_pago_reproduccion BIGINT NOT NULL AUTO_INCREMENT,
                    c_solicitud BIGINT NOT NULL,
                    c_solicitud_respuesta BIGINT NOT NULL,
                    c_usuario BIGINT,
                    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
                    x_tipo_copia VARCHAR(60) NOT NULL,
                    n_monto DECIMAL(10,2) NOT NULL,
                    x_moneda CHAR(3) DEFAULT 'PEN',
                    x_pasarela VARCHAR(60) DEFAULT 'CULQI ONLINE DEMO',
                    x_codigo_pago VARCHAR(80) NOT NULL,
                    x_estado VARCHAR(30) DEFAULT 'PAGADO',
                    x_estado_entrega VARCHAR(40) DEFAULT 'PENDIENTE DE PREPARACION',
                    x_copia_archivo VARCHAR(120) NULL,
                    x_copia_ubicacion VARCHAR(160) NULL,
                    f_preparacion DATETIME(6) NULL,
                    f_entrega DATETIME(6) NULL,
                    l_estado CHAR(1) DEFAULT 'S',
                    c_aud INT,
                    f_aud DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
                    b_aud CHAR(1) NOT NULL,
                    n_aud_ip VARCHAR(15),
                    PRIMARY KEY (c_pago_reproduccion),
                    INDEX idx_pagos_reproduccion_solicitud (c_solicitud),
                    INDEX idx_pagos_reproduccion_respuesta (c_solicitud_respuesta)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        Database::connection()->exec($sql);
        $this->ensureColumnExists('pagos_reproduccion', 'x_estado_entrega', "VARCHAR(40) DEFAULT 'PENDIENTE DE PREPARACION'");
        $this->ensureColumnExists('pagos_reproduccion', 'x_copia_archivo', 'VARCHAR(120) NULL');
        $this->ensureColumnExists('pagos_reproduccion', 'x_copia_ubicacion', 'VARCHAR(160) NULL');
        $this->ensureColumnExists('pagos_reproduccion', 'f_preparacion', 'DATETIME(6) NULL');
        $this->ensureColumnExists('pagos_reproduccion', 'f_entrega', 'DATETIME(6) NULL');
    }

    private function ensureColumnExists(string $table, string $column, string $definition): void
    {
        $stmt = Database::connection()->prepare("SELECT COUNT(*)
                                                 FROM INFORMATION_SCHEMA.COLUMNS
                                                 WHERE TABLE_SCHEMA = DATABASE()
                                                   AND TABLE_NAME = :table
                                                   AND COLUMN_NAME = :column");
        $stmt->execute(['table' => $table, 'column' => $column]);

        if ((int) $stmt->fetchColumn() === 0) {
            Database::connection()->exec("ALTER TABLE {$table} ADD COLUMN {$column} {$definition}");
        }
    }

    private function paidCopyData(int $paymentId): ?array
    {
        if ($paymentId <= 0) {
            return null;
        }

        $stmt = Database::connection()->prepare("SELECT p.*,
                                                        sr.x_archivo AS respuesta_archivo,
                                                        sr.x_ubicacion AS respuesta_ubicacion
                                                 FROM pagos_reproduccion p
                                                 INNER JOIN solicitudes_respuestas sr ON p.c_solicitud_respuesta = sr.c_solicitud_respuesta
                                                 WHERE p.c_pago_reproduccion = :pago
                                                   AND p.l_estado = 'S'
                                                   AND sr.l_estado = 'S'
                                                 LIMIT 1");
        $stmt->execute(['pago' => $paymentId]);
        $payment = $stmt->fetch();

        return $payment ?: null;
    }

    private function registerPaidCopyMovement(int $solicitud, string $observacion): void
    {
        $stmt = Database::connection()->prepare("SELECT c_corte
                                                 FROM solicitudes_ubicaciones
                                                 WHERE c_solicitud = :solicitud
                                                   AND l_estado = 'S'
                                                 ORDER BY c_solicitud_ubicacion DESC
                                                 LIMIT 1");
        $stmt->execute(['solicitud' => $solicitud]);
        $corte = (string) ($stmt->fetchColumn() ?: '');

        if ($corte === '') {
            return;
        }

        $this->insertRequestMovement($solicitud, $corte, '04', $observacion);
    }

    private function supportMessagesForTicket(int $ticketId): array
    {
        $stmt = Database::connection()->prepare("SELECT m.c_mensaje,
                                                        m.x_origen,
                                                        m.x_mensaje,
                                                        m.f_registro,
                                                        CONCAT(u.x_nombres, ' ', u.x_ap_paterno) AS usuario
                                                 FROM solicitudes_apoyo_mensajes m
                                                 LEFT JOIN usuarios u ON m.c_usuario = u.c_usuario
                                                 WHERE m.c_solicitud_apoyo = :ticket
                                                   AND m.l_estado = 'S'
                                                 ORDER BY m.f_registro ASC, m.c_mensaje ASC");
        $stmt->execute(['ticket' => $ticketId]);
        return $stmt->fetchAll();
    }

    private function expectsJson(): bool
    {
        return str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json')
            || strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest';
    }

    private function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    private function solicitudesResumen(): array
    {
        $sql = "SELECT s.c_solicitud AS Solicitud,
                       CONCAT(u.x_nombres, ' ', u.x_ap_paterno) AS Usuario,
                       COALESCE(c.x_corte, 'Sin corte') AS Corte,
                       COALESCE(e.x_tipo_solicitud_estado, 'Pendiente') AS Estado,
                       s.f_registro AS Registro
                FROM solicitudes s
                LEFT JOIN usuarios u ON s.c_usuario = u.c_usuario
                LEFT JOIN solicitudes_ubicaciones su ON su.c_solicitud_ubicacion = (
                    SELECT MAX(su2.c_solicitud_ubicacion)
                    FROM solicitudes_ubicaciones su2
                    WHERE su2.c_solicitud = s.c_solicitud AND su2.l_estado = 'S'
                )
                LEFT JOIN cortes_nacionales c ON su.c_corte = c.c_corte
                LEFT JOIN tipos_solicitud_estados e ON su.c_tipo_solicitud_estado = e.c_tipo_solicitud_estado
                ORDER BY s.f_registro DESC
                LIMIT 10";

        return Database::connection()->query($sql)->fetchAll();
    }

    private function solicitudesPorDestino(array $destinos): array
    {
        $conditions = [];
        $params = [];

        foreach ($destinos as $index => $destino) {
            $key = 'destino' . $index;
            $conditions[] = "UPPER(su.x_observacion) LIKE :{$key}";
            $params[$key] = '%' . strtoupper($destino) . '%';
        }

        $whereDestino = implode(' OR ', $conditions);

        $sql = "SELECT s.c_solicitud AS Solicitud,
                       CONCAT(u.x_nombres, ' ', u.x_ap_paterno) AS Ciudadano,
                       COALESCE(c.x_corte, 'Sin corte') AS Corte,
                       COALESCE(e.x_tipo_solicitud_estado, 'Pendiente') AS Estado,
                       su.x_observacion AS Derivacion,
                       su.f_registro AS Fecha,
                       su.c_corte AS _CorteCodigo,
                       COALESCE(anx.documentos, '') AS _Anexos
                FROM solicitudes s
                INNER JOIN usuarios u ON s.c_usuario = u.c_usuario
                INNER JOIN solicitudes_ubicaciones su ON su.c_solicitud_ubicacion = (
                    SELECT MAX(su2.c_solicitud_ubicacion)
                    FROM solicitudes_ubicaciones su2
                    WHERE su2.c_solicitud = s.c_solicitud AND su2.l_estado = 'S'
                )
                LEFT JOIN cortes_nacionales c ON su.c_corte = c.c_corte
                LEFT JOIN tipos_solicitud_estados e ON su.c_tipo_solicitud_estado = e.c_tipo_solicitud_estado
                LEFT JOIN (
                    SELECT c_solicitud,
                           GROUP_CONCAT(CONCAT(c_solicitud_anexo, '::', x_archivo) ORDER BY n_secuencia SEPARATOR '||') AS documentos
                    FROM solicitudes_anexos
                    WHERE l_estado = 'S'
                    GROUP BY c_solicitud
                ) anx ON s.c_solicitud = anx.c_solicitud
                WHERE s.l_estado = 'S'
                  AND su.c_tipo_solicitud_estado = '02'
                  AND ({$whereDestino})
                ORDER BY su.f_registro DESC";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    private function bandejaEntrada(): array
    {
        $sql = "SELECT s.c_solicitud AS Solicitud,
                       CONCAT(u.x_nombres, ' ', u.x_ap_paterno) AS Usuario,
                       su.c_corte AS CorteCodigo,
                       COALESCE(c.x_corte, 'Sin corte') AS Corte,
                       COALESCE(e.x_tipo_solicitud_estado, 'Pendiente') AS Estado,
                       s.f_registro AS Registro,
                       s.x_sustentacion AS Sustento,
                       CONCAT(v.x_tipo_via, ' ', s.x_nombre_via) AS Direccion,
                       CONCAT(di.x_distrito, ', ', p.x_provincia, ' - ', d.x_departamento) AS Ubigeo,
                       s.x_celular AS Celular,
                       s.x_telefono AS Telefono,
                       su.x_observacion AS Observacion,
                       COALESCE(anx.archivos, '') AS Archivos
                FROM solicitudes s
                LEFT JOIN usuarios u ON s.c_usuario = u.c_usuario
                LEFT JOIN solicitudes_ubicaciones su ON su.c_solicitud_ubicacion = (
                    SELECT MAX(su2.c_solicitud_ubicacion)
                    FROM solicitudes_ubicaciones su2
                    WHERE su2.c_solicitud = s.c_solicitud AND su2.l_estado = 'S'
                )
                LEFT JOIN cortes_nacionales c ON su.c_corte = c.c_corte
                LEFT JOIN tipos_solicitud_estados e ON su.c_tipo_solicitud_estado = e.c_tipo_solicitud_estado
                LEFT JOIN tipos_vias v ON s.c_tipo_via = v.c_tipo_via
                LEFT JOIN distritos di ON s.c_distrito = di.c_distrito
                LEFT JOIN provincias p ON s.c_provincia = p.c_provincia
                LEFT JOIN departamentos d ON s.c_departamento = d.c_departamento
                LEFT JOIN (
                    SELECT c_solicitud, GROUP_CONCAT(x_archivo ORDER BY n_secuencia SEPARATOR '||') AS archivos
                    FROM solicitudes_anexos
                    WHERE l_estado = 'S'
                    GROUP BY c_solicitud
                ) anx ON s.c_solicitud = anx.c_solicitud
                WHERE s.l_estado = 'S'
                ORDER BY s.f_registro DESC
                LIMIT 20";

        return Database::connection()->query($sql)->fetchAll();
    }
}
