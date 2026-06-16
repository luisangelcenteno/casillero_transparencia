<?php

namespace App\Support;

use App\Core\Database;

class AuditLogger
{
    public static function record(string $evento, string $modulo, string $accion, ?int $solicitud = null, ?string $detalle = null, ?int $usuario = null): void
    {
        try {
            self::ensureTable();

            $sql = "INSERT INTO auditorias_sistema (
                        c_usuario, c_solicitud, x_evento, x_modulo, x_accion,
                        x_detalle, n_ip, x_user_agent, l_estado
                    ) VALUES (
                        :usuario, :solicitud, :evento, :modulo, :accion,
                        :detalle, :ip, :user_agent, 'S'
                    )";

            Database::connection()->prepare($sql)->execute([
                'usuario' => $usuario ?? (isset($_SESSION['id_usuario']) ? (int) $_SESSION['id_usuario'] : null),
                'solicitud' => $solicitud ?: null,
                'evento' => mb_strtoupper(substr($evento, 0, 100), 'UTF-8'),
                'modulo' => mb_strtoupper(substr($modulo, 0, 80), 'UTF-8'),
                'accion' => mb_strtoupper(substr($accion, 0, 120), 'UTF-8'),
                'detalle' => $detalle,
                'ip' => substr($_SERVER['REMOTE_ADDR'] ?? '', 0, 45),
                'user_agent' => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255),
            ]);
        } catch (\Throwable $exception) {
            // La auditoria no debe interrumpir el proceso principal.
        }
    }

    public static function ensureTable(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS auditorias_sistema (
                    c_auditoria BIGINT NOT NULL AUTO_INCREMENT,
                    c_usuario BIGINT NULL,
                    c_solicitud BIGINT NULL,
                    f_registro DATETIME(6) DEFAULT CURRENT_TIMESTAMP(6),
                    x_evento VARCHAR(100) NOT NULL,
                    x_modulo VARCHAR(80) NOT NULL,
                    x_accion VARCHAR(120) NOT NULL,
                    x_detalle TEXT NULL,
                    n_ip VARCHAR(45) NULL,
                    x_user_agent VARCHAR(255) NULL,
                    l_estado CHAR(1) DEFAULT 'S',
                    PRIMARY KEY (c_auditoria),
                    INDEX idx_auditoria_usuario (c_usuario),
                    INDEX idx_auditoria_solicitud (c_solicitud),
                    INDEX idx_auditoria_evento (x_evento),
                    INDEX idx_auditoria_fecha (f_registro)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        Database::connection()->exec($sql);
    }
}
