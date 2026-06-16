<?php

namespace App\Models;

use App\Core\Database;

class Solicitud
{
    public static function resumenPorUsuario(int $userId): array
    {
        $pdo = Database::connection();

        $total = $pdo->prepare("SELECT count(*) FROM solicitudes WHERE c_usuario = ?");
        $total->execute([$userId]);

        $proceso = $pdo->prepare("SELECT count(DISTINCT sub.c_solicitud) FROM solicitudes s JOIN solicitudes_ubicaciones sub ON s.c_solicitud = sub.c_solicitud WHERE s.c_usuario = ? AND sub.c_tipo_solicitud_estado IN ('01','02')");
        $proceso->execute([$userId]);

        $atendidas = $pdo->prepare("SELECT count(DISTINCT sub.c_solicitud) FROM solicitudes s JOIN solicitudes_ubicaciones sub ON s.c_solicitud = sub.c_solicitud WHERE s.c_usuario = ? AND sub.c_tipo_solicitud_estado = '04'");
        $atendidas->execute([$userId]);

        $vencidas = $pdo->prepare("SELECT count(DISTINCT sub.c_solicitud) FROM solicitudes s JOIN solicitudes_ubicaciones sub ON s.c_solicitud = sub.c_solicitud WHERE s.c_usuario = ? AND sub.c_tipo_solicitud_estado = '05'");
        $vencidas->execute([$userId]);

        return [
            'total' => (int) $total->fetchColumn(),
            'proceso' => (int) $proceso->fetchColumn(),
            'atendidas' => (int) $atendidas->fetchColumn(),
            'vencidas' => (int) $vencidas->fetchColumn(),
        ];
    }

    public static function recientesPorUsuario(int $userId, int $limit = 5): array
    {
        $sql = "SELECT s.c_solicitud, s.f_registro, c.x_corte, e.c_tipo_solicitud_estado,
                       sub.x_observacion AS area_actual, s.n_tiempo_atencion, s.n_tiempo_prorroga
                FROM solicitudes s
                INNER JOIN solicitudes_ubicaciones sub ON sub.c_solicitud_ubicacion = (
                    SELECT MAX(sub2.c_solicitud_ubicacion)
                    FROM solicitudes_ubicaciones sub2
                    WHERE sub2.c_solicitud = s.c_solicitud AND sub2.l_estado = 'S'
                )
                INNER JOIN cortes_nacionales c ON sub.c_corte = c.c_corte
                INNER JOIN tipos_solicitud_estados e ON sub.c_tipo_solicitud_estado = e.c_tipo_solicitud_estado
                WHERE s.c_usuario = :user_id AND s.l_estado = 'S'
                ORDER BY s.f_registro DESC
                LIMIT {$limit}";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public static function todasPorUsuario(int $userId): array
    {
        $sql = "SELECT s.c_solicitud, s.f_registro, c.x_corte, e.x_tipo_solicitud_estado,
                       e.c_tipo_solicitud_estado, sub.x_observacion AS area_actual,
                       s.n_tiempo_atencion, s.n_tiempo_prorroga
                FROM solicitudes s
                INNER JOIN solicitudes_ubicaciones sub ON sub.c_solicitud_ubicacion = (
                    SELECT MAX(sub2.c_solicitud_ubicacion)
                    FROM solicitudes_ubicaciones sub2
                    WHERE sub2.c_solicitud = s.c_solicitud AND sub2.l_estado = 'S'
                )
                INNER JOIN cortes_nacionales c ON sub.c_corte = c.c_corte
                INNER JOIN tipos_solicitud_estados e ON sub.c_tipo_solicitud_estado = e.c_tipo_solicitud_estado
                WHERE s.c_usuario = :user_id AND s.l_estado = 'S'
                ORDER BY s.f_registro DESC";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public static function todas(): array
    {
        $sql = "SELECT s.c_solicitud, s.f_registro, c.x_corte, e.x_tipo_solicitud_estado,
                       e.c_tipo_solicitud_estado, sub.x_observacion AS area_actual,
                       s.n_tiempo_atencion, s.n_tiempo_prorroga
                FROM solicitudes s
                INNER JOIN solicitudes_ubicaciones sub ON sub.c_solicitud_ubicacion = (
                    SELECT MAX(sub2.c_solicitud_ubicacion)
                    FROM solicitudes_ubicaciones sub2
                    WHERE sub2.c_solicitud = s.c_solicitud AND sub2.l_estado = 'S'
                )
                INNER JOIN cortes_nacionales c ON sub.c_corte = c.c_corte
                INNER JOIN tipos_solicitud_estados e ON sub.c_tipo_solicitud_estado = e.c_tipo_solicitud_estado
                WHERE s.l_estado = 'S'
                ORDER BY s.f_registro DESC";

        return Database::connection()->query($sql)->fetchAll();
    }

    public static function detalle(int $solicitudId, ?int $userId = null): ?array
    {
        $sql = "SELECT s.*, d.x_departamento, p.x_provincia, di.x_distrito, v.x_tipo_via
                FROM solicitudes s
                INNER JOIN departamentos d ON s.c_departamento = d.c_departamento
                INNER JOIN provincias p ON s.c_provincia = p.c_provincia
                INNER JOIN distritos di ON s.c_distrito = di.c_distrito
                INNER JOIN tipos_vias v ON s.c_tipo_via = v.c_tipo_via
                WHERE s.c_solicitud = :id";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['id' => $solicitudId]);
        $solicitud = $stmt->fetch();

        if ($solicitud && $userId !== null && (int) $solicitud['c_usuario'] !== $userId) {
            return null;
        }

        return $solicitud ?: null;
    }

    public static function historial(int $solicitudId): array
    {
        $sql = "SELECT sub.*, cn.x_corte, se.x_tipo_solicitud_estado
                FROM solicitudes_ubicaciones sub
                INNER JOIN cortes_nacionales cn ON sub.c_corte = cn.c_corte
                INNER JOIN tipos_solicitud_estados se ON sub.c_tipo_solicitud_estado = se.c_tipo_solicitud_estado
                WHERE sub.c_solicitud = :id
                ORDER BY sub.f_registro DESC";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['id' => $solicitudId]);
        $rows = $stmt->fetchAll();
        $filtered = [];
        $lastKey = null;

        foreach ($rows as $row) {
            $key = implode('|', [
                $row['c_tipo_solicitud_estado'] ?? '',
                $row['c_corte'] ?? '',
                trim((string) ($row['x_observacion'] ?? '')),
            ]);

            if ($key === $lastKey) {
                continue;
            }

            $filtered[] = $row;
            $lastKey = $key;
        }

        return $filtered;
    }

    public static function anexos(int $solicitudId): array
    {
        $stmt = Database::connection()->prepare("SELECT * FROM solicitudes_anexos WHERE c_solicitud = ?");
        $stmt->execute([$solicitudId]);
        return $stmt->fetchAll();
    }

    public static function anexoDetalle(int $anexoId): ?array
    {
        $sql = "SELECT a.*, s.c_usuario
                FROM solicitudes_anexos a
                INNER JOIN solicitudes s ON a.c_solicitud = s.c_solicitud
                WHERE a.c_solicitud_anexo = :id AND a.l_estado = 'S'";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['id' => $anexoId]);
        $anexo = $stmt->fetch();

        return $anexo ?: null;
    }

    public static function respuestas(int $solicitudId): array
    {
        $stmt = Database::connection()->prepare("SELECT * FROM solicitudes_respuestas WHERE c_solicitud = ?");
        $stmt->execute([$solicitudId]);
        return $stmt->fetchAll();
    }

    public static function crear(array $data, array $cortes, array $files): void
    {
        $pdo = Database::connection();
        $pdo->beginTransaction();

        try {
            $sql = "INSERT INTO solicitudes (
                        c_usuario, c_tipo_via, c_tipo_zona, c_departamento, c_provincia,
                        c_distrito, x_nombre_via, x_referencia, x_telefono, x_celular,
                        x_sustentacion, n_tiempo_atencion, l_estado, b_aud, c_aud, n_aud_ip
                    ) VALUES (
                        :usuario, :via, :zona, :departamento, :provincia, :distrito,
                        :nombre_via, :referencia, :telefono, :celular, :sustentacion,
                        10, 'S', 'I', :auditoria, :ip
                    )";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
            $solicitudId = (int) $pdo->lastInsertId();

            $ubicacion = $pdo->prepare("INSERT INTO solicitudes_ubicaciones (
                            c_solicitud, c_usuario, c_tipo_solicitud_estado, c_corte,
                            x_observacion, l_estado, b_aud, c_aud, n_aud_ip
                        ) VALUES (
                            :solicitud, :usuario, '01', :corte,
                            'REGISTRO INICIAL POR EL CIUDADANO', 'S', 'I', :auditoria, :ip
                        )");

            foreach ($cortes as $corte) {
                $ubicacion->execute([
                    'solicitud' => $solicitudId,
                    'usuario' => $data['usuario'],
                    'corte' => $corte,
                    'auditoria' => $data['auditoria'],
                    'ip' => $data['ip'],
                ]);
            }

            self::guardarAnexos($solicitudId, $data['auditoria'], $data['ip'], $files);
            $pdo->commit();
        } catch (\Throwable $exception) {
            $pdo->rollBack();
            throw $exception;
        }
    }

    private static function guardarAnexos(int $solicitudId, int $userId, string $ip, array $files): void
    {
        if (!isset($files['anexos'])) {
            return;
        }

        $targetDir = dirname(__DIR__, 2) . '/storage/uploads/anexos/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $anexos = $files['anexos'];
        $stmt = Database::connection()->prepare("INSERT INTO solicitudes_anexos (
                    c_solicitud, n_secuencia, x_archivo, x_ubicacion, l_estado, b_aud, c_aud, n_aud_ip
                ) VALUES (
                    :solicitud, :secuencia, :archivo, :ubicacion, 'S', 'I', :usuario, :ip
                )");

        for ($i = 0; $i < count($anexos['name']); $i++) {
            if ($anexos['error'][$i] !== UPLOAD_ERR_OK || empty($anexos['name'][$i])) {
                continue;
            }

            $extension = pathinfo($anexos['name'][$i], PATHINFO_EXTENSION);
            $nuevoNombre = 'SOL_' . $solicitudId . '_ANX_' . ($i + 1) . '_' . time() . '.' . $extension;
            $rutaFisica = $targetDir . $nuevoNombre;

            if (move_uploaded_file($anexos['tmp_name'][$i], $rutaFisica)) {
                $stmt->execute([
                    'solicitud' => $solicitudId,
                    'secuencia' => $i + 1,
                    'archivo' => $anexos['name'][$i],
                    'ubicacion' => 'uploads/anexos/' . $nuevoNombre,
                    'usuario' => $userId,
                    'ip' => $ip,
                ]);
            }
        }
    }
}
