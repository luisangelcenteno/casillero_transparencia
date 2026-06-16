<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Catalog;
use App\Models\User;
use App\Support\AuditLogger;

class AuthController extends Controller
{
    public function login(): void
    {
        if (isset($_SESSION['id_usuario'])) {
            $this->redirect('/dashboard');
        }

        $this->view('auth.login');
    }

    public function authenticate(): void
    {
        $correo = trim($_POST['correo'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($correo === '' || $password === '') {
            $this->redirect('/login?error=campos_vacios');
        }

        $user = User::findActiveByEmail($correo);

        if (!$user || $password !== $user['x_contrasena']) {
            AuditLogger::record(
                'AUTENTICACION Y CIFRADO DE CREDENCIALES',
                'AUTENTICACION',
                'INTENTO DE INICIO DE SESION FALLIDO',
                null,
                'Correo: ' . $correo
            );
            $this->redirect('/login?error=credenciales_invalidas');
        }

        $_SESSION['id_usuario'] = $user['c_usuario'];
        $_SESSION['nombre_usuario'] = $user['x_nombres'] . ' ' . $user['x_ap_paterno'];
        $_SESSION['id_perfil'] = $user['c_tipo_perfil'];
        $_SESSION['nombre_perfil'] = $user['x_tipo_perfil'];

        AuditLogger::record(
            'AUTENTICACION Y CIFRADO DE CREDENCIALES',
            'AUTENTICACION',
            'INICIO DE SESION EXITOSO',
            null,
            'Perfil: ' . $user['x_tipo_perfil'],
            (int) $user['c_usuario']
        );

        $this->redirect('/dashboard');
    }

    public function register(): void
    {
        $this->view('auth.register', [
            'tiposPersona' => Catalog::tiposPersona(),
        ]);
    }

    public function storeRegister(): void
    {
        if (($_POST['x_contrasena'] ?? '') !== ($_POST['conf_contrasena'] ?? '')) {
            $this->redirect('/registro?error=password');
        }

        User::createCitizen([
            'persona' => $_POST['c_tipo_persona'] ?? '',
            'documento' => trim($_POST['n_documento'] ?? ''),
            'nombres' => mb_strtoupper(trim($_POST['x_nombres'] ?? ''), 'UTF-8'),
            'ap_paterno' => mb_strtoupper(trim($_POST['x_ap_paterno'] ?? ''), 'UTF-8'),
            'ap_materno' => mb_strtoupper(trim($_POST['x_ap_materno'] ?? ''), 'UTF-8'),
            'correo' => trim($_POST['x_correo'] ?? ''),
            'contrasena' => $_POST['x_contrasena'] ?? '',
            'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
        ]);

        $this->redirect('/login?msg=registro_exitoso');
    }

    public function recover(): void
    {
        $this->view('auth.recover');
    }

    public function sendRecovery(): void
    {
        $correo = trim($_POST['correo'] ?? '');
        $user = User::findActiveByEmail($correo);

        if (!$user) {
            $this->redirect('/recuperar?error=email_no_encontrado');
        }

        User::createRecoveryToken((int) $user['c_usuario'], bin2hex(random_bytes(32)), $_SERVER['REMOTE_ADDR'] ?? '');
        $this->redirect('/recuperar?msg=correo_enviado');
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        $this->redirect('/login?msg=sesion_cerrada');
    }
}
