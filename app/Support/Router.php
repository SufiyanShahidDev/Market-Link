<?php
namespace App\Support;
class Router {
    public function __construct(private array $routes) {}
    public function dispatch(string $method, string $uri): void {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $base = rtrim(BASE_URL, '/');
        if ($base !== '' && str_starts_with($path, $base)) $path = substr($path, strlen($base)) ?: '/';
        foreach ($this->routes as [$m,$route,$handler]) {
            if ($m === $method && $route === $path) { [$class,$action]=$handler; (new $class())->$action(); return; }
        }
        http_response_code(404); echo '<h1>404</h1><p>Route not found.</p>';
    }
}
