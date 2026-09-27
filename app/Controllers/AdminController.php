<?php

namespace App\Controllers;

require_once __DIR__ . '/../Support/bootstrap.php';

class AdminController
{
    public function home(): void
    {
        $pageTitle = 'MarketLink';
        require_role('admin');
        $pdo = db();
        $counts = [];
        foreach (['customers' => "SELECT COUNT(*) FROM users WHERE role='customer'", 'farmers' => "SELECT COUNT(*) FROM users WHERE role='farmer' AND approval_status='approved'", 'pending_farmers' => "SELECT COUNT(*) FROM users WHERE role='farmer' AND approval_status='pending'", 'products' => "SELECT COUNT(*) FROM products", 'orders' => "SELECT COUNT(*) FROM orders", 'revenue' => "SELECT COALESCE(SUM(total_amount),0) FROM orders WHERE status='completed'"] as $k => $sql) $counts[$k] = $pdo->query($sql)->fetchColumn();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/admin/index.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function farmers(): void
    {
        $pageTitle = 'MarketLink';
        require_role('admin');
        $pdo = db();
        $farmers = $pdo->query("SELECT u.*,m.name market_name FROM users u LEFT JOIN markets m ON m.id=u.market_id WHERE u.role='farmer' ORDER BY u.created_at DESC")->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/admin/farmers.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function customers(): void
    {
        $pageTitle = 'MarketLink';
        require_role('admin');
        $users = db()->query("SELECT * FROM users WHERE role='customer' ORDER BY created_at DESC")->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/admin/customers.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function markets(): void
    {
        $pageTitle = 'MarketLink';
        require_role('admin');
        $pdo = db();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verify_csrf();
            $id = (int)($_POST['id'] ?? 0);
            $action = $_POST['action'] ?? 'save';
            if ($action === 'delete') {
                $pdo->prepare("DELETE FROM markets WHERE id=?")->execute([$id]);
                flash('success', 'Market deleted.');
            } else {
                $name = trim($_POST['name'] ?? '');
                $address = trim($_POST['address'] ?? '');
                $lat = (float)($_POST['latitude'] ?? 0);
                $lng = (float)($_POST['longitude'] ?? 0);
                $status = $_POST['status'] ?? 'active';
                if ($id) $pdo->prepare("UPDATE markets SET name=?,address=?,latitude=?,longitude=?,status=? WHERE id=?")->execute([$name, $address, $lat, $lng, $status, $id]);
                else $pdo->prepare("INSERT INTO markets(name,address,latitude,longitude,status) VALUES(?,?,?,?,?)")->execute([$name, $address, $lat, $lng, $status]);
                flash('success', 'Market saved.');
            }
            redirect('admin/markets.php');
        }
        $markets = $pdo->query("SELECT * FROM markets ORDER BY name")->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/admin/markets.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function categories(): void
    {
        $pageTitle = 'MarketLink';
        require_role('admin');
        $pdo = db();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verify_csrf();
            $id = (int)($_POST['id'] ?? 0);
            $action = $_POST['action'] ?? 'save';
            if ($action === 'delete') $pdo->prepare("DELETE FROM categories WHERE id=?")->execute([$id]);
            else {
                $name = trim($_POST['name'] ?? '');
                if ($id) $pdo->prepare("UPDATE categories SET name=? WHERE id=?")->execute([$name, $id]);
                else $pdo->prepare("INSERT INTO categories(name,status) VALUES(?,'active')")->execute([$name]);
            }
            flash('success', 'Category saved.');
            redirect('admin/categories.php');
        }
        $cats = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/admin/categories.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function products(): void
    {
        $pageTitle = 'MarketLink';
        require_role('admin');
        $p = db()->query("SELECT p.*,u.name farmer_name,c.name category_name FROM products p LEFT JOIN users u ON u.id=p.farmer_id LEFT JOIN categories c ON c.id=p.category_id ORDER BY FIELD(p.status,'pending','approved','rejected'),p.created_at DESC")->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/admin/products.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function reviews(): void
    {
        $pageTitle = 'MarketLink';
        require_role('admin');
        $reviews = db()->query("SELECT r.*,p.name product_name,u.name customer_name FROM reviews r JOIN products p ON p.id=r.product_id JOIN users u ON u.id=r.customer_id ORDER BY FIELD(r.status,'pending','approved','rejected'),r.created_at DESC")->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/admin/reviews.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function reports(): void
    {
        $pageTitle = 'MarketLink';
        require_role('admin');
        $pdo = db();
        $stats = ['sales' => $pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM orders WHERE status='completed'")->fetchColumn(), 'orders' => $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(), 'customers' => $pdo->query("SELECT COUNT(*) FROM users WHERE role='customer'")->fetchColumn(), 'farmers' => $pdo->query("SELECT COUNT(*) FROM users WHERE role='farmer' AND approval_status='approved'")->fetchColumn()];
        $top = $pdo->query("SELECT p.name,SUM(oi.quantity) units,SUM(oi.subtotal) revenue FROM order_items oi JOIN products p ON p.id=oi.product_id JOIN orders o ON o.id=oi.order_id WHERE o.status='completed' GROUP BY p.id ORDER BY units DESC LIMIT 10")->fetchAll();
        $history = $pdo->query("SELECT * FROM reports ORDER BY created_at DESC LIMIT 10")->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/admin/reports.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function notifications(): void
    {
        $pageTitle = 'MarketLink';
        require_role('admin');
        $pdo = db();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verify_csrf();
            $title = trim($_POST['title'] ?? '');
            $message = trim($_POST['message'] ?? '');
            $audience = $_POST['audience'] ?? 'all';
            $sql = "SELECT id FROM users WHERE role IN ('customer','farmer') AND status='active'";
            if (in_array($audience, ['customer', 'farmer'], true)) $sql = "SELECT id FROM users WHERE role=? AND status='active'";
            $q = $pdo->prepare($sql);
            $audience === 'all' ? $q->execute() : $q->execute([$audience]);
            foreach ($q->fetchAll() as $u) notify_user($u['id'], $title, $message, 'admin');
            flash('success', 'Notification sent.');
            redirect('admin/notifications.php');
        }

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/admin/notifications.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }
}
