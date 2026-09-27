<?php
declare(strict_types=1);
require_once __DIR__ . '/app/Support/bootstrap.php';
require_once __DIR__ . '/app/Support/Router.php';

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) return;
    $relative = str_replace('\\', '/', substr($class, strlen($prefix)));
    $file = __DIR__ . '/app/' . $relative . '.php';
    if (is_file($file)) require_once $file;
});
$router = new \App\Support\Router(require __DIR__ . '/routes/web.php');
$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
