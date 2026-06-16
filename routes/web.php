<?php

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\ModuleController;
use App\Controllers\SolicitudController;
use App\Controllers\UbigeoController;
use App\Core\Router;

$router = new Router();

$router->get('/', [AuthController::class, 'login']);
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'authenticate']);
$router->get('/registro', [AuthController::class, 'register']);
$router->post('/registro', [AuthController::class, 'storeRegister']);
$router->get('/recuperar', [AuthController::class, 'recover']);
$router->post('/recuperar', [AuthController::class, 'sendRecovery']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/solicitudes', [SolicitudController::class, 'index']);
$router->get('/solicitudes/crear', [SolicitudController::class, 'create']);
$router->post('/solicitudes', [SolicitudController::class, 'store']);
$router->get('/solicitudes/detalle', [SolicitudController::class, 'show']);
$router->post('/solicitudes/apoyo', [SolicitudController::class, 'support']);
$router->get('/solicitudes/apoyo/mensajes', [SolicitudController::class, 'supportMessagesJson']);
$router->post('/solicitudes/apoyo/mensaje', [SolicitudController::class, 'supportMessage']);
$router->post('/pagos/reproduccion', [SolicitudController::class, 'reproductionPayment']);
$router->get('/documentos/anexo', [SolicitudController::class, 'anexo']);
$router->get('/ubigeo', [UbigeoController::class, 'index']);

$moduleRoutes = [
    'bandeja-entrada',
    'derivar-expedientes',
    'supervision',
    'reportes',
    'actualizar-estados',
    'adjuntar-documentos',
    'alertas-sla',
    'auditoria',
    'busqueda-documental',
    'preparar-anexos',
    'validar-ingresos',
    'remitir-solicitudes',
    'indicadores',
    'coordinacion',
    'analisis-sla',
    'incumplimientos',
    'usuarios',
    'perfiles',
    'catalogos',
    'soporte-sla',
    'pagos-culqi',
    'auditoria-sistema',
];

foreach ($moduleRoutes as $route) {
    $router->get('/modulos/' . $route, [ModuleController::class, 'show']);
}

$router->post('/modulos/derivar', [ModuleController::class, 'derive']);
$router->post('/modulos/mesa-partes/validar', [ModuleController::class, 'validateIncome']);
$router->post('/modulos/mesa-partes/remitir', [ModuleController::class, 'remitIncome']);
$router->post('/modulos/mesa-partes/observar', [ModuleController::class, 'observeIncome']);
$router->post('/modulos/archivo/ubicacion', [ModuleController::class, 'archiveLocation']);
$router->post('/modulos/archivo/no-encontrado', [ModuleController::class, 'archiveNotFound']);
$router->post('/modulos/archivo/preparar', [ModuleController::class, 'archivePrepare']);
$router->post('/modulos/archivo/remitir', [ModuleController::class, 'archiveRemit']);
$router->post('/modulos/firmar-respuesta', [ModuleController::class, 'signResponse']);
$router->post('/modulos/subir-firma-jefatura', [ModuleController::class, 'uploadSignature']);
$router->post('/modulos/actualizar-firma-jefatura', [ModuleController::class, 'updateSignature']);
$router->post('/modulos/eliminar-firma-jefatura', [ModuleController::class, 'deleteSignature']);
$router->get('/firmas/jefatura', [ModuleController::class, 'signatureFile']);
$router->get('/documentos/firmado', [ModuleController::class, 'signedDocument']);
$router->get('/documentos/verificar', [ModuleController::class, 'verifyDocument']);
$router->get('/documentos/respuesta', [ModuleController::class, 'responseFile']);
$router->get('/documentos/copia-pagada', [ModuleController::class, 'paidCopyFile']);
$router->get('/plantillas/descargar', [ModuleController::class, 'downloadTemplate']);
$router->get('/modulos/soporte-sla/mensajes', [ModuleController::class, 'supportMessagesJson']);
$router->post('/modulos/soporte-sla/estado', [ModuleController::class, 'updateSupportSla']);
$router->post('/modulos/soporte-sla/mensaje', [ModuleController::class, 'supportMessage']);
$router->post('/modulos/pagos-culqi/preparar', [ModuleController::class, 'prepareCulqiCopy']);
$router->post('/modulos/pagos-culqi/entregar', [ModuleController::class, 'deliverCulqiCopy']);

return $router;
