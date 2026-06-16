<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Catalog;
use App\Models\Solicitud;
use App\Support\AuditLogger;

class SolicitudController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();
        $perfil = $_SESSION['id_perfil'] ?? '';

        $this->view('solicitudes.index', [
            'solicitudes' => $this->canViewAllRequests($perfil)
                ? Solicitud::todas()
                : Solicitud::todasPorUsuario((int) $_SESSION['id_usuario']),
        ]);
    }

    public function create(): void
    {
        $this->requireCitizen();

        $this->view('solicitudes.create', [
            'cortes' => Catalog::cortes(),
            'vias' => Catalog::vias(),
            'zonas' => Catalog::zonas(),
            'departamentos' => Catalog::departamentos(),
        ]);
    }

    public function store(): void
    {
        $this->requireCitizen();

        $cortes = $_POST['cortes'] ?? [];
        $sustentacion = trim($_POST['x_sustentacion'] ?? '');

        if (empty($cortes) || $sustentacion === '') {
            $this->redirect('/solicitudes/crear?error=datos_incompletos');
        }

        $solicitudId = Solicitud::crear([
            'usuario' => (int) $_SESSION['id_usuario'],
            'via' => $_POST['c_tipo_via'] ?? '',
            'zona' => $_POST['c_tipo_zona'] ?? '',
            'departamento' => $_POST['c_departamento'] ?? '',
            'provincia' => $_POST['c_provincia'] ?? '',
            'distrito' => $_POST['c_distrito'] ?? '',
            'nombre_via' => mb_strtoupper(trim($_POST['x_nombre_via'] ?? ''), 'UTF-8'),
            'referencia' => mb_strtoupper(trim($_POST['x_referencia'] ?? ''), 'UTF-8'),
            'telefono' => trim($_POST['x_telefono'] ?? ''),
            'celular' => trim($_POST['x_celular'] ?? ''),
            'sustentacion' => $sustentacion,
            'auditoria' => (int) $_SESSION['id_usuario'],
            'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
        ], $cortes, $_FILES);

        AuditLogger::record(
            'PRESENTACION DE SOLICITUD',
            'CIUDADANO',
            'REGISTRO DE SOLICITUD',
            $solicitudId,
            'Solicitud presentada por el ciudadano con documentos anexos.'
        );

        $this->redirect('/dashboard?msg=solicitud_enviada');
    }

    public function show(): void
    {
        $this->requireAuth();

        $solicitudId = (int) ($_GET['id'] ?? 0);
        $perfil = $_SESSION['id_perfil'] ?? '';
        $userId = $this->canViewAllRequests($perfil) ? null : (int) $_SESSION['id_usuario'];
        $solicitud = Solicitud::detalle($solicitudId, $userId);

        if (!$solicitud) {
            http_response_code(403);
            echo 'Acceso denegado o solicitud no encontrada.';
            return;
        }

        $this->view('solicitudes.show', [
            'solicitud' => $solicitud,
            'historial' => Solicitud::historial($solicitudId),
            'anexos' => Solicitud::anexos($solicitudId),
            'respuestas' => Solicitud::respuestas($solicitudId),
            'supportTicket' => $this->supportTicket($solicitudId),
            'supportMessages' => $this->supportMessages($solicitudId),
            'reproductionPayments' => $this->reproductionPayments($solicitudId),
        ]);
    }

    public function support(): void
    {
        $this->requireAuth();
        $this->ensureSupportTable();

        $solicitudId = (int) ($_POST['c_solicitud'] ?? 0);
        $anexoId = (int) ($_POST['c_anexo'] ?? 0);
        $motivo = trim($_POST['x_motivo'] ?? '');
        $descripcion = trim($_POST['x_descripcion'] ?? '');

        $perfil = $_SESSION['id_perfil'] ?? '';
        $userId = (int) ($_SESSION['id_usuario'] ?? 0);
        $solicitud = Solicitud::detalle($solicitudId, $this->canViewAllRequests($perfil) ? null : $userId);

        if (!$solicitud || $motivo === '') {
            $this->redirect('/solicitudes/detalle?id=' . $solicitudId . '&error=apoyo');
        }

        $this->createSupportTicket($solicitudId, $anexoId, $motivo, $descripcion);
        AuditLogger::record(
            'INCIDENCIA Y ATENCION SLA',
            'SOPORTE SLA',
            'REGISTRO DE INCIDENCIA',
            $solicitudId,
            $motivo . ' | ' . $descripcion
        );
        $this->redirect('/solicitudes/detalle?id=' . $solicitudId . '&msg=apoyo');
    }

    public function supportMessage(): void
    {
        $this->requireAuth();
        $this->ensureSupportTable();
        $this->ensureSupportMessagesTable();

        $solicitudId = (int) ($_POST['c_solicitud'] ?? 0);
        $mensaje = trim($_POST['x_mensaje'] ?? '');
        $accion = trim($_POST['accion'] ?? '');

        $perfil = $_SESSION['id_perfil'] ?? '';
        $userId = (int) ($_SESSION['id_usuario'] ?? 0);
        $solicitud = Solicitud::detalle($solicitudId, $this->canViewAllRequests($perfil) ? null : $userId);

        if (!$solicitud || ($mensaje === '' && $accion === '')) {
            if ($this->expectsJson()) {
                $this->json(['ok' => false, 'message' => 'Solicitud o mensaje invalido.'], 422);
                return;
            }
            $this->redirect('/solicitudes/detalle?id=' . $solicitudId . '&error=apoyo');
        }

        if ($mensaje === '') {
            $mensaje = 'Necesito conversar con Administracion del Sistema para solucionar mi problema.';
        }

        $ticketId = $this->findOrCreateSupportTicketForChat($solicitudId);
        $this->insertSupportMessage($ticketId, $solicitudId, 'CIUDADANO', $mensaje);
        AuditLogger::record(
            'INCIDENCIA Y ATENCION SLA',
            'CHAT SOPORTE',
            'MENSAJE DEL CIUDADANO',
            $solicitudId,
            $mensaje
        );

        if ($this->expectsJson()) {
            $this->json([
                'ok' => true,
                'ticket' => $this->supportTicket($solicitudId),
                'messages' => $this->supportMessages($solicitudId),
            ]);
            return;
        }

        $this->redirect('/solicitudes/detalle?id=' . $solicitudId . '&msg=chat');
    }

    public function supportMessagesJson(): void
    {
        $this->requireAuth();
        $this->ensureSupportTable();
        $this->ensureSupportMessagesTable();

        $solicitudId = (int) ($_GET['solicitud'] ?? 0);
        $perfil = $_SESSION['id_perfil'] ?? '';
        $userId = (int) ($_SESSION['id_usuario'] ?? 0);
        $solicitud = Solicitud::detalle($solicitudId, $this->canViewAllRequests($perfil) ? null : $userId);

        if (!$solicitud) {
            $this->json(['ok' => false, 'message' => 'No autorizado.'], 403);
            return;
        }

        $this->json([
            'ok' => true,
            'ticket' => $this->supportTicket($solicitudId),
            'messages' => $this->supportMessages($solicitudId),
        ]);
    }

    public function reproductionPayment(): void
    {
        $this->requireAuth();
        $this->ensureReproductionPaymentsTable();

        $solicitudId = (int) ($_POST['c_solicitud'] ?? 0);
        $respuestaId = (int) ($_POST['c_solicitud_respuesta'] ?? 0);
        $tipo = trim($_POST['x_tipo_copia'] ?? '');
        $validTypes = [
            'COPIA SIMPLE' => 5.00,
            'COPIA CERTIFICADA' => 15.00,
            'ENVIO A DOMICILIO' => 10.00,
        ];

        $perfil = $_SESSION['id_perfil'] ?? '';
        $userId = (int) ($_SESSION['id_usuario'] ?? 0);
        $solicitud = Solicitud::detalle($solicitudId, $this->canViewAllRequests($perfil) ? null : $userId);

        if (!$solicitud || $respuestaId <= 0 || !array_key_exists($tipo, $validTypes)) {
            $this->redirect('/solicitudes/detalle?id=' . $solicitudId . '&error=pago');
        }

        $codigoPago = 'CULQI-DEMO-' . date('YmdHis') . '-' . random_int(100, 999);
        Database::connection()->prepare("INSERT INTO pagos_reproduccion (
                                             c_solicitud, c_solicitud_respuesta, c_usuario,
                                             x_tipo_copia, n_monto, x_moneda, x_pasarela,
                                             x_codigo_pago, x_estado, l_estado, c_aud, b_aud, n_aud_ip
                                         ) VALUES (
                                             :solicitud, :respuesta, :usuario,
                                             :tipo, :monto, 'PEN', 'CULQI ONLINE DEMO',
                                             :codigo, 'PAGADO', 'S', :auditoria, 'I', :ip
                                         )")->execute([
            'solicitud' => $solicitudId,
            'respuesta' => $respuestaId,
            'usuario' => $userId,
            'tipo' => $tipo,
            'monto' => $validTypes[$tipo],
            'codigo' => $codigoPago,
            'auditoria' => $userId,
            'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
        ]);

        $this->registerPaymentMovement($solicitudId, $tipo, $validTypes[$tipo], $codigoPago);
        AuditLogger::record(
            'PAGO DE REPRODUCCION',
            'CULQI ONLINE DEMO',
            'PAGO REGISTRADO',
            $solicitudId,
            $tipo . ' | S/ ' . number_format($validTypes[$tipo], 2) . ' | ' . $codigoPago
        );
        $this->redirect('/solicitudes/detalle?id=' . $solicitudId . '&msg=pago');
    }

    public function anexo(): void
    {
        $this->requireAuth();

        $anexoId = (int) ($_GET['id'] ?? 0);
        $perfil = $_SESSION['id_perfil'] ?? '';
        $anexo = Solicitud::anexoDetalle($anexoId);

        if (!$anexo) {
            http_response_code(404);
            echo 'Documento no encontrado.';
            return;
        }

        $isOwner = (int) $anexo['c_usuario'] === (int) ($_SESSION['id_usuario'] ?? 0);
        if (!$isOwner && !$this->canViewAllRequests($perfil)) {
            http_response_code(403);
            echo 'Acceso denegado.';
            return;
        }

        $path = dirname(__DIR__, 2) . '/storage/' . ltrim($anexo['x_ubicacion'], '/');
        if (!is_file($path)) {
            $this->ensureSupportTable();
            $this->createSupportTicket(
                (int) $anexo['c_solicitud'],
                (int) $anexo['c_solicitud_anexo'],
                'ARCHIVO FISICO NO ENCONTRADO',
                'El anexo figura en la base de datos, pero no existe en la carpeta storage/uploads/anexos.'
            );
            http_response_code(404);
            echo 'Archivo fisico no encontrado. Se registro una solicitud de apoyo para Administracion del Sistema.';
            return;
        }

        $extension = strtolower(pathinfo($anexo['x_archivo'], PATHINFO_EXTENSION));
        $mime = match ($extension) {
            'pdf' => 'application/pdf',
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            default => 'application/octet-stream',
        };

        header('Content-Type: ' . $mime);
        header('Content-Disposition: inline; filename="' . basename($anexo['x_archivo']) . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }

    private function canViewAllRequests(string $perfil): bool
    {
        return in_array($perfil, ['02', '03', '04', '05', '06', '07', '08', '09', '10'], true);
    }

    private function createSupportTicket(int $solicitudId, int $anexoId, string $motivo, string $descripcion): void
    {
        $sql = "INSERT INTO solicitudes_apoyo (
                    c_solicitud, c_solicitud_anexo, c_usuario_reporta,
                    x_motivo, x_descripcion, x_estado, n_sla_horas,
                    l_estado, c_aud, b_aud, n_aud_ip
                ) VALUES (
                    :solicitud, :anexo, :usuario,
                    :motivo, :descripcion, 'PENDIENTE', 24,
                    'S', :auditoria, 'I', :ip
                )";

        Database::connection()->prepare($sql)->execute([
            'solicitud' => $solicitudId,
            'anexo' => $anexoId > 0 ? $anexoId : null,
            'usuario' => (int) ($_SESSION['id_usuario'] ?? 0),
            'motivo' => mb_strtoupper($motivo, 'UTF-8'),
            'descripcion' => $descripcion,
            'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
            'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
        ]);
    }

    private function findOrCreateSupportTicketForChat(int $solicitudId): int
    {
        $stmt = Database::connection()->prepare("SELECT c_solicitud_apoyo
                                                 FROM solicitudes_apoyo
                                                 WHERE c_solicitud = :solicitud
                                                   AND l_estado = 'S'
                                                   AND x_estado IN ('PENDIENTE', 'EN ATENCION')
                                                 ORDER BY c_solicitud_apoyo DESC
                                                 LIMIT 1");
        $stmt->execute(['solicitud' => $solicitudId]);
        $ticketId = (int) $stmt->fetchColumn();

        if ($ticketId > 0) {
            return $ticketId;
        }

        $this->createSupportTicket(
            $solicitudId,
            0,
            'CONVERSACION CON ADMINISTRADOR',
            'El ciudadano solicita apoyo guiado desde el asistente virtual.'
        );

        return (int) Database::connection()->lastInsertId();
    }

    private function insertSupportMessage(int $ticketId, int $solicitudId, string $origen, string $mensaje): void
    {
        Database::connection()->prepare("INSERT INTO solicitudes_apoyo_mensajes (
                                             c_solicitud_apoyo, c_solicitud, c_usuario,
                                             x_origen, x_mensaje, l_estado, c_aud, b_aud, n_aud_ip
                                         ) VALUES (
                                             :ticket, :solicitud, :usuario,
                                             :origen, :mensaje, 'S', :auditoria, 'I', :ip
                                         )")->execute([
            'ticket' => $ticketId,
            'solicitud' => $solicitudId,
            'usuario' => (int) ($_SESSION['id_usuario'] ?? 0),
            'origen' => $origen,
            'mensaje' => $mensaje,
            'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
            'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
        ]);
    }

    private function supportTicket(int $solicitudId): ?array
    {
        $this->ensureSupportTable();

        $stmt = Database::connection()->prepare("SELECT *
                                                 FROM solicitudes_apoyo
                                                 WHERE c_solicitud = :solicitud
                                                   AND l_estado = 'S'
                                                 ORDER BY c_solicitud_apoyo DESC
                                                 LIMIT 1");
        $stmt->execute(['solicitud' => $solicitudId]);
        $ticket = $stmt->fetch();

        return $ticket ?: null;
    }

    private function supportMessages(int $solicitudId): array
    {
        $this->ensureSupportMessagesTable();

        $stmt = Database::connection()->prepare("SELECT m.*, CONCAT(u.x_nombres, ' ', u.x_ap_paterno) AS usuario
                                                 FROM solicitudes_apoyo_mensajes m
                                                 LEFT JOIN usuarios u ON m.c_usuario = u.c_usuario
                                                 WHERE m.c_solicitud = :solicitud
                                                   AND m.l_estado = 'S'
                                                 ORDER BY m.f_registro ASC, m.c_mensaje ASC");
        $stmt->execute(['solicitud' => $solicitudId]);

        return $stmt->fetchAll();
    }

    private function reproductionPayments(int $solicitudId): array
    {
        $this->ensureReproductionPaymentsTable();

        $stmt = Database::connection()->prepare("SELECT *
                                                 FROM pagos_reproduccion
                                                 WHERE c_solicitud = :solicitud
                                                   AND l_estado = 'S'
                                                 ORDER BY f_registro DESC");
        $stmt->execute(['solicitud' => $solicitudId]);

        return $stmt->fetchAll();
    }

    private function registerPaymentMovement(int $solicitudId, string $tipo, float $monto, string $codigoPago): void
    {
        $stmt = Database::connection()->prepare("SELECT c_corte
                                                 FROM solicitudes_ubicaciones
                                                 WHERE c_solicitud = :solicitud
                                                   AND l_estado = 'S'
                                                 ORDER BY c_solicitud_ubicacion DESC
                                                 LIMIT 1");
        $stmt->execute(['solicitud' => $solicitudId]);
        $corte = (string) ($stmt->fetchColumn() ?: '');

        if ($corte === '') {
            return;
        }

        Database::connection()->prepare("INSERT INTO solicitudes_ubicaciones (
                                             c_solicitud, c_usuario, c_tipo_solicitud_estado, c_corte,
                                             x_observacion, l_estado, b_aud, c_aud, n_aud_ip
                                         ) VALUES (
                                             :solicitud, :usuario, '04', :corte,
                                             :observacion, 'S', 'I', :auditoria, :ip
                                         )")->execute([
            'solicitud' => $solicitudId,
            'usuario' => (int) ($_SESSION['id_usuario'] ?? 0),
            'corte' => $corte,
            'observacion' => 'PAGO DE REPRODUCCION CONFIRMADO | ' . $tipo . ' | S/ ' . number_format($monto, 2) . ' | ' . $codigoPago,
            'auditoria' => (int) ($_SESSION['id_usuario'] ?? 0),
            'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 15),
        ]);
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
}
