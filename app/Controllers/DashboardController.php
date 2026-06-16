<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Solicitud;

class DashboardController extends Controller
{
    public function index(): void
    {
        $this->requireAuth();

        $userId = (int) $_SESSION['id_usuario'];

        $this->view('dashboard.index', [
            'resumen' => Solicitud::resumenPorUsuario($userId),
            'recientes' => Solicitud::recientesPorUsuario($userId),
            'perfil' => $this->perfilActual(),
        ]);
    }

    private function perfilActual(): array
    {
        $perfilId = $_SESSION['id_perfil'] ?? '';

        $perfiles = [
            '01' => [
                'titulo' => 'Ciudadano',
                'descripcion' => 'Registra solicitudes de transparencia y consulta el estado de sus tramites.',
                'acciones' => ['Registrar solicitudes', 'Ver mis solicitudes', 'Consultar trazabilidad'],
                'color' => 'primary',
                'icono' => 'bi-person-fill',
            ],
            '02' => [
                'titulo' => 'Responsable de Transparencia',
                'descripcion' => 'Recibe, evalua y deriva solicitudes hacia las areas responsables.',
                'acciones' => ['Revisar bandeja de entrada', 'Derivar expedientes', 'Registrar observaciones'],
                'color' => 'success',
                'icono' => 'bi-inboxes-fill',
            ],
            '03' => [
                'titulo' => 'Jefe Administrativo',
                'descripcion' => 'Supervisa la atencion interna y puede ejecutar la actualizacion operativa de documentos cuando corresponde.',
                'acciones' => ['Supervision', 'Reportes', 'Actualizar estados', 'Adjuntar documentos'],
                'color' => 'warning',
                'icono' => 'bi-diagram-3-fill',
            ],
            '04' => [
                'titulo' => 'Asistente Administrativo',
                'descripcion' => 'Apoya el movimiento documental y actualiza el avance de solicitudes.',
                'acciones' => ['Actualizar estados', 'Adjuntar documentos', 'Registrar movimientos'],
                'color' => 'info',
                'icono' => 'bi-clipboard-check-fill',
            ],
            '05' => [
                'titulo' => 'Responsable ODANC',
                'descripcion' => 'Controla alertas de vencimiento y revisa el cumplimiento de plazos.',
                'acciones' => ['Auditar plazos', 'Ver solicitudes vencidas', 'Emitir alertas'],
                'color' => 'danger',
                'icono' => 'bi-shield-exclamation',
            ],
            '06' => [
                'titulo' => 'Tecnico de Archivo',
                'descripcion' => 'Ubica informacion documental y prepara anexos para responder solicitudes.',
                'acciones' => ['Buscar documentos', 'Preparar anexos', 'Informar disponibilidad'],
                'color' => 'secondary',
                'icono' => 'bi-archive-fill',
            ],
            '07' => [
                'titulo' => 'Mesa de Partes',
                'descripcion' => 'Registra ingresos, valida datos iniciales y remite solicitudes al area competente.',
                'acciones' => ['Validar ingresos', 'Registrar recepcion', 'Enviar a transparencia'],
                'color' => 'primary',
                'icono' => 'bi-envelope-paper-fill',
            ],
            '08' => [
                'titulo' => 'Supervisor General',
                'descripcion' => 'Monitorea indicadores globales y coordina acciones entre perfiles operativos.',
                'acciones' => ['Ver indicadores', 'Coordinar areas', 'Controlar productividad'],
                'color' => 'dark',
                'icono' => 'bi-bar-chart-fill',
            ],
            '09' => [
                'titulo' => 'Auditor de Plazos',
                'descripcion' => 'Revisa cumplimiento normativo y genera alertas sobre solicitudes en riesgo.',
                'acciones' => ['Analizar SLA', 'Detectar riesgos', 'Reportar incumplimientos'],
                'color' => 'danger',
                'icono' => 'bi-stopwatch-fill',
            ],
            '10' => [
                'titulo' => 'Administrador del Sistema',
                'descripcion' => 'Tiene acceso global a todas las opciones operativas, perfiles, usuarios y configuraciones de la plataforma.',
                'acciones' => ['Ver todos los modulos', 'Administrar usuarios', 'Gestionar perfiles', 'Configurar catalogos'],
                'color' => 'dark',
                'icono' => 'bi-gear-fill',
            ],
        ];

        return $perfiles[$perfilId] ?? [
            'titulo' => $_SESSION['nombre_perfil'] ?? 'Perfil no definido',
            'descripcion' => 'Perfil pendiente de configuracion.',
            'acciones' => ['Consultar con el administrador'],
            'color' => 'secondary',
            'icono' => 'bi-person-badge-fill',
        ];
    }
}
