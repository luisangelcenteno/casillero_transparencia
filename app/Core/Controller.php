<?php

namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require dirname(__DIR__, 2) . '/resources/views/' . str_replace('.', '/', $view) . '.php';
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . url($path));
        exit;
    }

    protected function requireAuth(): void
    {
        if (!isset($_SESSION['id_usuario'])) {
            $this->redirect('/login');
        }
    }

    protected function requireCitizen(): void
    {
        $this->requireAuth();

        if ($_SESSION['id_perfil'] !== '01') {
            $this->redirect('/dashboard');
        }
    }
}
