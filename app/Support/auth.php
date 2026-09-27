<?php
require_once __DIR__ . '/db.php';
function current_user(): ?array
{
    static $userLoaded = false;
    static $user = null;
    if ($userLoaded) return $user;
    $userLoaded = true;
    if (empty($_SESSION['user_id'])) return null;
    $st = db()->prepare('SELECT * FROM users WHERE id=? LIMIT 1');
    $st->execute([$_SESSION['user_id']]);
    $user = $st->fetch() ?: null;
    return $user;
}
function require_login(): void
{
    if (!current_user()) {
        flash('warning', 'Please login first.');
        redirect('login.php');
    }
}
function require_role(string $role): void
{
    require_login();
    if (current_user()['role'] !== $role) {
        http_response_code(403);
        exit('403 Forbidden');
    }
}
function role_home(?string $role = null): string
{
    $role = $role ?? (current_user()['role'] ?? '');
    return match ($role) {
        'admin' => 'admin/index.php',
        'farmer' => 'farmer/index.php',
        'customer' => 'dashboard.php',
        default => 'login.php'
    };
}
