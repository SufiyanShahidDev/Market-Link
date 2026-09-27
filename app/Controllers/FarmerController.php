<?php

namespace App\Controllers;

require_once __DIR__ . '/../Support/bootstrap.php';

class FarmerController
{
    public function home(): void
    {
        $pageTitle = 'MarketLink';
        require_role('farmer');
        $pdo = db();
        $uid = current_user()['id'];
        $stats = [];
        foreach (['products' => "SELECT COUNT(*) FROM products WHERE farmer_id=?", 'pending_orders' => "SELECT COUNT(*) FROM orders o JOIN order_items oi ON oi.order_id=o.id LEFT JOIN products p ON p.id=oi.product_id WHERE oi.farmer_id=? AND o.status='pending'", 'revenue' => "SELECT COALESCE(SUM(oi.subtotal),0) FROM order_items oi JOIN orders o ON o.id=oi.order_id LEFT JOIN products p ON p.id=oi.product_id WHERE oi.farmer_id=? AND o.status='completed'", 'reviews' => "SELECT COUNT(*) FROM reviews r JOIN products p ON p.id=r.product_id WHERE p.farmer_id=? AND r.status='approved'"] as $k => $sql) {
            $q = $pdo->prepare($sql);
            $q->execute([$uid]);
            $stats[$k] = $q->fetchColumn();
        }
        $top = $pdo->prepare("SELECT p.name,SUM(oi.quantity) units,SUM(oi.subtotal) revenue FROM order_items oi JOIN orders o ON o.id=oi.order_id LEFT JOIN products p ON p.id=oi.product_id WHERE oi.farmer_id=? AND o.status='completed' GROUP BY p.id ORDER BY units DESC LIMIT 5");
        $top->execute([$uid]);
        $top = $top->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/farmer/index.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function products(): void
    {
        $pageTitle = 'MarketLink';
        require_role('farmer');
        $st = db()->prepare("SELECT p.*,c.name category_name FROM products p LEFT JOIN categories c ON c.id=p.category_id WHERE p.farmer_id=? ORDER BY p.created_at DESC");
        $st->execute([current_user()['id']]);
        $products = $st->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/farmer/products.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function product_form(): void
    {
        $pageTitle = 'MarketLink';
        require_role('farmer');
        $id = (int)($_GET['id'] ?? 0);
        $pdo = db();
        $product = ['name' => '', 'category_id' => '', 'description' => '', 'price' => '', 'stock' => 0, 'image' => null];
        if ($id) {
            $st = $pdo->prepare("SELECT * FROM products WHERE id=? AND farmer_id=?");
            $st->execute([$id, current_user()['id']]);
            $product = $st->fetch();
            if (!$product) exit('Product not found.');
        }
        $cats = $pdo->query("SELECT * FROM categories WHERE status='active' ORDER BY name")->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/farmer/product_form.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function orders(): void
    {
        $pageTitle = 'MarketLink';
        require_role('farmer');
        $st = db()->prepare("SELECT DISTINCT o.*,u.name customer_name,u.phone, m.name market_name FROM orders o JOIN order_items oi ON oi.order_id=o.id JOIN products p ON p.id=oi.product_id JOIN users u ON u.id=o.customer_id LEFT JOIN markets m ON m.id=o.market_id WHERE p.farmer_id=? ORDER BY o.created_at DESC");
        $st->execute([current_user()['id']]);
        $orders = $st->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/farmer/orders.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function profile(): void
    {
        $pageTitle = 'MarketLink';
        require_role('farmer');
        $u = current_user();
        $markets = db()->query("SELECT id,name FROM markets WHERE status='active' ORDER BY name")->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/farmer/profile.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function reviews(): void
    {
        $pageTitle = 'MarketLink';
        require_role('farmer');
        $uid = current_user()['id'];
        $st = db()->prepare("SELECT r.*,p.name product_name,u.name customer_name FROM reviews r JOIN products p ON p.id=r.product_id JOIN users u ON u.id=r.customer_id WHERE p.farmer_id=? AND r.status='approved' ORDER BY r.created_at DESC");
        $st->execute([$uid]);
        $reviews = $st->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/farmer/reviews.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function sales(): void
    {
        $pageTitle = 'MarketLink';
        require_role('farmer');
        $pdo = db();
        $uid = current_user()['id'];
        $st = $pdo->prepare("SELECT DATE(o.created_at) sale_date, SUM(oi.subtotal) revenue FROM order_items oi JOIN orders o ON o.id=oi.order_id LEFT JOIN products p ON p.id=oi.product_id WHERE oi.farmer_id=? AND o.status='completed' GROUP BY DATE(o.created_at) ORDER BY sale_date DESC LIMIT 14");
        $st->execute([$uid]);
        $rows = $st->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/farmer/sales.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function schedule(): void
    {
        $pageTitle = 'MarketLink';
        require_role('farmer');
        $pdo = db();
        $uid = current_user()['id'];
        $products = $pdo->prepare("SELECT id,name FROM products WHERE farmer_id=? ORDER BY name");
        $products->execute([$uid]);
        $products = $products->fetchAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verify_csrf();
            $pid = (int)($_POST['product_id'] ?? 0);
            $check = $pdo->prepare("SELECT id FROM products WHERE id=? AND farmer_id=?");
            $check->execute([$pid, $uid]);
            if ($check->fetch()) {
                for ($d = 0; $d < 7; $d++) {
                    $qty = max(0, (int)($_POST['day_' . $d] ?? 0));
                    $pdo->prepare("INSERT INTO weekly_stock(product_id,day_of_week,available_qty) VALUES(?,?,?) ON DUPLICATE KEY UPDATE available_qty=VALUES(available_qty)")->execute([$pid, $d, $qty]);
                }
                flash('success', 'Weekly stock schedule saved.');
            }
            redirect('farmer/schedule.php');
        }
        $schedules = [];
        foreach ($products as $p) {
            $q = $pdo->prepare("SELECT day_of_week,available_qty FROM weekly_stock WHERE product_id=?");
            $q->execute([$p['id']]);
            $s = [];
            foreach ($q->fetchAll() as $r) $s[$r['day_of_week']] = $r['available_qty'];
            $schedules[$p['id']] = $s;
        }
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/farmer/schedule.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }
}
