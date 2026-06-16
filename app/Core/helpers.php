<?php

function asset(string $path): string
{
    return base_url('/assets/' . ltrim($path, '/'));
}

function url(string $path): string
{
    return base_url($path);
}

function base_url(string $path = ''): string
{
    $base = dirname($_SERVER['SCRIPT_NAME'] ?? '');
    $base = str_replace('\\', '/', $base);
    $base = $base === '/' ? '' : rtrim($base, '/');

    return $base . '/' . ltrim($path, '/');
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function old_query(string $key, string $default = ''): string
{
    return $_GET[$key] ?? $default;
}

function calcularSLA(string $fechaInicio, int $diasLey, int $diasProrroga): array
{
    $plazoTotal = $diasLey + $diasProrroga;
    $fechaActual = new DateTime();
    $fechaRegistro = new DateTime($fechaInicio);
    $diasPasados = $fechaRegistro->diff($fechaActual)->days;
    $diasRestantes = $plazoTotal - $diasPasados;

    if ($diasRestantes > 3) {
        return ['color' => 'success', 'texto' => "Verde: {$diasRestantes} dias", 'vencido' => false];
    }

    if ($diasRestantes >= 0) {
        return ['color' => 'warning', 'texto' => "Ambar: {$diasRestantes} dias", 'vencido' => false];
    }

    return ['color' => 'danger', 'texto' => 'Rojo: Vencido', 'vencido' => true];
}
