<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User
{
    public static function findActiveByEmail(string $email): ?array
    {
        $sql = "SELECT u.c_usuario, u.x_nombres, u.x_ap_paterno, u.x_contrasena,
                       u.c_tipo_perfil, p.x_tipo_perfil
                FROM usuarios u
                INNER JOIN tipos_perfiles p ON u.c_tipo_perfil = p.c_tipo_perfil
                WHERE u.x_correo = :correo AND u.l_estado = 'S'";

        $stmt = Database::connection()->prepare($sql);
        $stmt->execute(['correo' => $email]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public static function createCitizen(array $data): void
    {
        $sql = "INSERT INTO usuarios (
                    c_tipo_perfil, c_tipo_persona, n_documento, x_nombres,
                    x_ap_paterno, x_ap_materno, x_correo, x_contrasena,
                    l_estado, b_aud, c_aud, n_aud_ip
                ) VALUES (
                    '01', :persona, :documento, :nombres, :ap_paterno,
                    :ap_materno, :correo, :contrasena, 'S', 'I', 0, :ip
                )";

        Database::connection()->prepare($sql)->execute($data);
    }

    public static function createRecoveryToken(int $userId, string $token, string $ip): void
    {
        $sql = "INSERT INTO recuperaciones_contrasenas (
                    c_usuario, x_hash, l_estado, b_aud, c_aud, n_aud_ip
                ) VALUES (
                    :usuario, :hash, 'S', 'I', 0, :ip
                )";

        Database::connection()->prepare($sql)->execute([
            'usuario' => $userId,
            'hash' => $token,
            'ip' => $ip,
        ]);
    }
}
