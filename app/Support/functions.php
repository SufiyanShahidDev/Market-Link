<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';
function url(string $path = ''): string
{
    $path = ltrim($path, '/');
    // Clean, human-readable MVC URLs. Keep query strings intact.
    $map = [
        'index.php' => 'home',
        'login.php' => 'login',
        'register.php' => 'register',
        'logout.php' => 'logout',
        'products.php' => 'products',
        'product.php' => 'product',
        'markets.php' => 'markets',
        'farmers.php' => 'farmers',
        'cart.php' => 'cart',
        'checkout.php' => 'checkout',
        'orders.php' => 'orders',
        'order_view.php' => 'order',
        'favorites.php' => 'favorites',
        'profile.php' => 'profile',
        'notifications.php' => 'notifications',
        'assistant.php' => 'assistant',
        'dashboard.php' => 'dashboard',
        'farmer/index.php' => 'farmer/home',
        'farmer/products.php' => 'farmer/products',
        'farmer/product_form.php' => 'farmer/product-form',
        'farmer/orders.php' => 'farmer/orders',
        'farmer/profile.php' => 'farmer/profile',
        'farmer/reviews.php' => 'farmer/reviews',
        'farmer/sales.php' => 'farmer/sales',
        'farmer/schedule.php' => 'farmer/schedule',
        'admin/index.php' => 'admin/home',
        'admin/farmers.php' => 'admin/farmers',
        'admin/customers.php' => 'admin/customers',
        'admin/markets.php' => 'admin/markets',
        'admin/categories.php' => 'admin/categories',
        'admin/products.php' => 'admin/products',
        'admin/reviews.php' => 'admin/reviews',
        'admin/reports.php' => 'admin/reports',
        'admin/notifications.php' => 'admin/notifications',
    ];
    $query = '';
    $qpos = strpos($path, '?');
    if ($qpos !== false) {
        $query = substr($path, $qpos);
        $path = substr($path, 0, $qpos);
    }
    $path = $map[$path] ?? $path;
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/') . $query;
}
function e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
function redirect(string $path): never
{
    if (preg_match('~^https?://~i', $path)) header('Location: ' . $path);
    else header('Location: ' . url($path));
    exit;
}
function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}
function get_flash(): ?array
{
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}
function verify_csrf(): void
{
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf_token'] ?? '')) {
        http_response_code(419);
        exit('Invalid CSRF token.');
    }
}
function money($value): string
{
    return number_format((float)$value, 2);
}
function status_badge(string $status): string
{
    $map = ['active' => 'success', 'approved' => 'success', 'accepted' => 'primary', 'ready' => 'info', 'completed' => 'success', 'pending' => 'warning', 'inactive' => 'secondary', 'suspended' => 'danger', 'declined' => 'danger', 'cancelled' => 'danger', 'rejected' => 'danger'];
    $c = $map[$status] ?? 'secondary';
    return '<span class="badge text-bg-' . $c . '">' . e(ucfirst($status)) . '</span>';
}
function product_image(?string $file): string
{
    return $file ? url('uploads/products/' . $file) : url('assets/img/product-placeholder.svg');
}
function profile_image(?string $file): string
{
    return $file ? url('uploads/profiles/' . $file) : url('assets/img/avatar-placeholder.svg');
}
function upload_image(array $file, string $folder): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return null;
    if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > MAX_UPLOAD_SIZE) throw new RuntimeException('Image must be under 3 MB.');
    $info = @getimagesize($file['tmp_name']);
    if (!$info) throw new RuntimeException('Invalid image file.');
    $mime = $info['mime'];
    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    if (!isset($allowed[$mime])) throw new RuntimeException('Only JPG, PNG and WEBP images are allowed.');
    $name = bin2hex(random_bytes(10)) . '.' . $allowed[$mime];
    $dir = UPLOAD_DIR . '/' . $folder;
    if (!is_dir($dir)) mkdir($dir, 0775, true);
    move_uploaded_file($file['tmp_name'], $dir . '/' . $name);
    return $name;
}
function notify_user(int $userId, string $title, string $message, string $type = 'system'): void
{
    $st = db()->prepare('INSERT INTO notifications(user_id,title,message,type) VALUES(?,?,?,?)');
    $st->execute([$userId, $title, $message, $type]);
}
function unread_count(): int
{
    if (!current_user()) return 0;
    $st = db()->prepare('SELECT COUNT(*) FROM notifications WHERE user_id=? AND is_read=0');
    $st->execute([current_user()['id']]);
    return (int)$st->fetchColumn();
}

function svg_icon(string $name, string $class = 'icon', string $label = ''): string
{
    $paths = [
        'bell' => '<path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>',
        'sparkles' => '<path d="m12 3-1.5 5.5L5 10l5.5 1.5L12 17l1.5-5.5L19 10l-5.5-1.5L12 3Z"/><path d="m19 15-.7 2.3L16 18l2.3.7L19 21l.7-2.3L22 18l-2.3-.7L19 15Z"/>',
        'arrow-right' => '<path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>',
        'location' => '<path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/>',
        'leaf' => '<path d="M20 4C12 4 5 8 5 15c0 2 1 4 4 4 7 0 11-7 11-15Z"/><path d="M5 19c3-5 7-7 12-9"/>',
        'check' => '<path d="m5 12 4 4L19 6"/>',
        'cart' => '<circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/><path d="M3 4h2l2.4 11.2a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 1.9-1.5L21 8H6"/>',
        'seedling' => '<path d="M12 21V9"/><path d="M12 13c-4 0-7-2.5-7-7 4 0 7 2.5 7 7Z"/><path d="M12 11c0-4 3-7 7-7 0 4.5-3 7-7 7Z"/>',
        'search' => '<circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>',
        'heart' => '<path d="M20.8 8.6c0 5.5-8.8 10.4-8.8 10.4S3.2 14.1 3.2 8.6A4.6 4.6 0 0 1 12 6.2a4.6 4.6 0 0 1 8.8 2.4Z"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'menu' => '<path d="M4 6h16M4 12h16M4 18h16"/>',
        'user' => '<circle cx="12" cy="8" r="3"/><path d="M5 21a7 7 0 0 1 14 0"/>',
        'facebook' => '<path d="M14 8h3V4h-3c-3.3 0-5 2-5 5v3H6v4h3v5h4v-5h3l1-4h-4V9c0-.7.3-1 1-1Z"/>',
        'instagram' => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".8" fill="currentColor" stroke="none"/>',
        'linkedin' => '<path d="M5 8v11M5 5v.1M9 19v-6a4 4 0 0 1 8 0v6M9 12V8"/>',
        'filter' => '<path d="M4 6h16M7 12h10M10 18h4"/>',
    ];
    $body = $paths[$name] ?? $paths['leaf'];
    $aria = $label !== '' ? ' aria-label="' . e($label) . '"' : ' aria-hidden="true"';
    return '<svg class="' . e($class) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" focusable="false"' . $aria . '>' . $body . '</svg>';
}
