<?php

namespace App\Models;

use App\Core\Database;

class Catalog
{
    public static function tiposPersona(): array
    {
        return Database::connection()
            ->query("SELECT c_tipo_persona, x_tipo_persona FROM tipos_personas WHERE c_tipo_persona != '06' AND l_estado = 'S' ORDER BY c_tipo_persona")
            ->fetchAll();
    }

    public static function cortes(): array
    {
        return Database::connection()
            ->query("SELECT c_corte, x_corte FROM cortes_nacionales WHERE l_estado = 'S' ORDER BY x_corte")
            ->fetchAll();
    }

    public static function vias(): array
    {
        return Database::connection()
            ->query("SELECT c_tipo_via, x_tipo_via FROM tipos_vias WHERE l_estado = 'S' ORDER BY x_tipo_via")
            ->fetchAll();
    }

    public static function zonas(): array
    {
        return Database::connection()
            ->query("SELECT c_tipo_zona, x_tipo_zona FROM tipos_zonas WHERE l_estado = 'S' ORDER BY x_tipo_zona")
            ->fetchAll();
    }

    public static function departamentos(): array
    {
        return Database::connection()
            ->query("SELECT c_departamento, x_departamento FROM departamentos WHERE l_estado = 'S' ORDER BY x_departamento")
            ->fetchAll();
    }

    public static function provincias(string $departamento): array
    {
        $stmt = Database::connection()->prepare("SELECT c_provincia, x_provincia FROM provincias WHERE c_departamento = :dep AND l_estado = 'S' ORDER BY x_provincia");
        $stmt->execute(['dep' => $departamento]);
        return $stmt->fetchAll();
    }

    public static function distritos(string $provincia): array
    {
        $stmt = Database::connection()->prepare("SELECT c_distrito, x_distrito FROM distritos WHERE c_provincia = :prov AND l_estado = 'S' ORDER BY x_distrito");
        $stmt->execute(['prov' => $provincia]);
        return $stmt->fetchAll();
    }
}
