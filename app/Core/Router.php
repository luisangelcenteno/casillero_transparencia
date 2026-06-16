<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $uri, array $action): void
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post(string $uri, array $action): void
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH) ?: '/';
        $base = dirname($_SERVER['SCRIPT_NAME'] ?? '');
        $base = str_replace('\\', '/', $base);
        $base = $base === '/' ? '' : rtrim($base, '/');

        if ($base !== '' && str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base)) ?: '/';
        }

        $uri = rtrim($uri, '/') ?: '/';
        $action = $this->routes[$method][$uri] ?? null;

        if (!$action) {
            http_response_code(404);
            echo '404 - Ruta no encontrada';
            return;
        }

        [$controller, $methodName] = $action;
        (new $controller())->$methodName();
    }
}
