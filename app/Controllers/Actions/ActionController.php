<?php

namespace App\Controllers\Actions;

require_once __DIR__ . '/../../Support/bootstrap.php';

class ActionController
{
    public function admin(): void
    {
        require_role('admin');

        // Report downloads (read-only GET requests, handled before the POST-only check below)
        $getAction = $_GET['action'] ?? '';
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && $getAction === 'download_report') {
            $this->downloadCurrentReport();
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && $getAction === 'download_saved_report') {
            $this->downloadSavedReport((int)($_GET['id'] ?? 0));
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('admin/index.php');
        verify_csrf();
        $pdo = db();
        $action = $_POST['action'] ?? '';
        $id = (int)($_POST['id'] ?? 0);
        switch ($action) {
            case 'approve':
                $pdo->prepare("UPDATE users SET approval_status='approved' WHERE id=? AND role='farmer'")->execute([$id]);
                notify_user($id, 'Farmer account approved', 'Your MarketLink farmer account has been approved.', 'admin');
                flash('success', 'Farmer approved.');
                break;
            case 'suspend':
                $pdo->prepare("UPDATE users SET approval_status='suspended' WHERE id=? AND role='farmer'")->execute([$id]);
                notify_user($id, 'Farmer account suspended', 'Your farmer account has been suspended by admin.', 'admin');
                flash('success', 'Farmer suspended.');
                break;
            case 'restore_farmer':
                $pdo->prepare("UPDATE users SET approval_status='approved',status='active' WHERE id=? AND role='farmer'")->execute([$id]);
                notify_user($id, 'Farmer account restored', 'Your MarketLink farmer account has been restored.', 'admin');
                flash('success', 'Farmer restored.');
                break;
            case 'activate':
                $pdo->prepare("UPDATE users SET status='active' WHERE id=?")->execute([$id]);
                flash('success', 'User activated.');
                break;
            case 'deactivate':
                $pdo->prepare("UPDATE users SET status='inactive' WHERE id=?")->execute([$id]);
                flash('success', 'User deactivated.');
                break;
            case 'approve_product':
                $pdo->prepare("UPDATE products SET status='approved' WHERE id=?")->execute([$id]);
                flash('success', 'Product approved.');
                break;
            case 'reject_product':
                $pdo->prepare("UPDATE products SET status='rejected' WHERE id=?")->execute([$id]);
                flash('success', 'Product rejected.');
                break;
            case 'approve_review':
                $pdo->prepare("UPDATE reviews SET status='approved' WHERE id=?")->execute([$id]);
                flash('success', 'Review approved.');
                break;
            case 'reject_review':
                $pdo->prepare("UPDATE reviews SET status='rejected' WHERE id=?")->execute([$id]);
                flash('success', 'Review rejected.');
                break;
            case 'generate_report':
                $sales = $pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM orders WHERE status='completed'")->fetchColumn();
                $orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
                $pdo->prepare("INSERT INTO reports(report_type,period_start,period_end,total_sales,total_orders) VALUES('Current Snapshot',CURDATE(),CURDATE(),?,?)")->execute([$sales, $orders]);
                flash('success', 'Report snapshot saved.');
                break;
            default:
                flash('warning', 'No action selected.');
        }
        redirect($_SERVER['HTTP_REFERER'] ?? 'admin/index.php');
    }

    private function downloadCurrentReport(): void
    {
        $pdo = db();
        $stats = ['sales' => $pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM orders WHERE status='completed'")->fetchColumn(), 'orders' => $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn(), 'customers' => $pdo->query("SELECT COUNT(*) FROM users WHERE role='customer'")->fetchColumn(), 'farmers' => $pdo->query("SELECT COUNT(*) FROM users WHERE role='farmer' AND approval_status='approved'")->fetchColumn()];
        $top = $pdo->query("SELECT p.name,SUM(oi.quantity) units,SUM(oi.subtotal) revenue FROM order_items oi JOIN products p ON p.id=oi.product_id JOIN orders o ON o.id=oi.order_id WHERE o.status='completed' GROUP BY p.id ORDER BY units DESC LIMIT 10")->fetchAll();

        while (ob_get_level()) ob_end_clean();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="report_' . date('Y-m-d_H-i') . '.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, ['MarketLink - Reports & Analytics']);
        fputcsv($out, ['Generated on', date('Y-m-d H:i')]);
        fputcsv($out, []);
        fputcsv($out, ['Metric', 'Value']);
        fputcsv($out, ['Completed sales', 'Rs. ' . money($stats['sales'])]);
        fputcsv($out, ['Total orders', $stats['orders']]);
        fputcsv($out, ['Customers', $stats['customers']]);
        fputcsv($out, ['Approved farmers', $stats['farmers']]);
        fputcsv($out, []);
        fputcsv($out, ['Product', 'Units', 'Revenue']);
        foreach ($top as $t) fputcsv($out, [$t['name'], $t['units'], 'Rs. ' . money($t['revenue'])]);
        fclose($out);
        exit;
    }

    private function downloadSavedReport(int $id): void
    {
        if (!$id) {
            flash('danger', 'Invalid report.');
            redirect('admin/reports.php');
        }
        $pdo = db();
        $st = $pdo->prepare("SELECT * FROM reports WHERE id=?");
        $st->execute([$id]);
        $report = $st->fetch();
        if (!$report) {
            flash('danger', 'Report not found.');
            redirect('admin/reports.php');
        }

        while (ob_get_level()) ob_end_clean();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="report_' . $report['id'] . '_' . $report['period_start'] . '.csv"');

        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, ['Report Type', $report['report_type']]);
        fputcsv($out, ['Period', $report['period_start'] . ' to ' . $report['period_end']]);
        fputcsv($out, ['Total Sales', 'Rs. ' . money($report['total_sales'])]);
        if (isset($report['total_orders'])) fputcsv($out, ['Total Orders', $report['total_orders']]);
        fclose($out);
        exit;
    }

    public function cart(): void
    {
        require_role('customer');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('cart.php');
        verify_csrf();
        $action = $_POST['action'] ?? '';
        $_SESSION['cart'] = $_SESSION['cart'] ?? [];
        $id = (int)($_POST['product_id'] ?? 0);
        $qty = (int)($_POST['quantity'] ?? 1);
        $pdo = db();
        if ($action === 'add') {
            $st = $pdo->prepare("SELECT id,stock,status,is_sold_out FROM products WHERE id=?");
            $st->execute([$id]);
            $p = $st->fetch();
            if (!$p || $p['status'] !== 'approved' || $p['is_sold_out'] || $qty < 1 || $qty > (int)$p['stock']) {
                flash('danger', 'This quantity is not available.');
                redirect('product.php?id=' . $id);
            }
            $_SESSION['cart'][$id] = min((int)$p['stock'], ($_SESSION['cart'][$id] ?? 0) + $qty);
            flash('success', 'Product added to cart.');
            redirect('cart.php');
        }
        if ($action === 'update') {
            $st = $pdo->prepare("SELECT stock FROM products WHERE id=?");
            $st->execute([$id]);
            $stock = (int)$st->fetchColumn();
            if ($qty < 1) $qty = 1;
            $_SESSION['cart'][$id] = min($qty, $stock);
            flash('success', 'Cart updated.');
            redirect('cart.php');
        }
        if ($action === 'remove') {
            unset($_SESSION['cart'][$id]);
            flash('success', 'Item removed.');
            redirect('cart.php');
        }
        if ($action === 'clear') {
            $_SESSION['cart'] = [];
            flash('success', 'Cart cleared.');
            redirect('cart.php');
        }
        redirect('cart.php');
    }

    public function checkout(): void
    {


        require_role('customer');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('checkout.php');
        verify_csrf();
        $cart = $_SESSION['cart'] ?? [];
        if (!$cart) redirect('cart.php');
        $date = $_POST['pickup_date'] ?? '';
        $time = $_POST['pickup_time'] ?? '';
        $note = trim($_POST['note'] ?? '');
        if (!$date || !$time || strtotime($date) < strtotime(date('Y-m-d'))) {
            flash('danger', 'Please provide a valid pickup date and time.');
            redirect('checkout.php');
        }
        $pdo = db();
        $pdo->beginTransaction();
        try {
            $ids = array_keys($cart);
            $in = implode(',', array_fill(0, count($ids), '?'));
            $st = $pdo->prepare("SELECT p.*,u.id farmer_id,u.market_id,m.name market_name FROM products p JOIN users u ON u.id=p.farmer_id JOIN markets m ON m.id=u.market_id WHERE p.id IN ($in) FOR UPDATE");
            $st->execute($ids);
            $products = $st->fetchAll();
            if (count($products) !== count($ids)) throw new Exception('Some products are unavailable.');
            $groups = [];
            foreach ($products as $p) {
                $q = (int)$cart[$p['id']];
                if ($p['status'] !== 'approved' || $p['is_sold_out'] || $q < 1 || $q > $p['stock']) throw new Exception('Stock changed for ' . $p['name'] . '. Please review your cart.');
                $groups[$p['farmer_id']][] = ['product' => $p, 'qty' => $q];
            }
            $created = [];
            foreach ($groups as $farmerId => $items) {
                $total = 0;
                foreach ($items as $item) $total += $item['product']['price'] * $item['qty'];
                $o = $pdo->prepare("INSERT INTO orders(customer_id,market_id,pickup_date,pickup_time,note,total_amount,status) VALUES(?,?,?,?,?,?,'pending')");
                $marketId = $items[0]['product']['market_id'];
                $o->execute([current_user()['id'], $marketId, $date, $time, $note, $total]);
                $oid = $pdo->lastInsertId();
                $created[] = $oid;
                $oi = $pdo->prepare("INSERT INTO order_items(order_id,product_id,product_name,farmer_id,quantity,unit_price,subtotal) VALUES(?,?,?,?,?,?,?)");
                $up = $pdo->prepare("UPDATE products SET stock=stock-? WHERE id=?");
                foreach ($items as $item) {
                    $q = $item['qty'];
                    $p = $item['product'];
                    $oi->execute([$oid, $p['id'], $p['name'], $farmerId, $q, $p['price'], $q * $p['price']]);
                    $up->execute([$q, $p['id']]);
                }
            }
            $pdo->commit();
            $_SESSION['cart'] = [];
            foreach ($created as $oid) notify_user(current_user()['id'], 'Pre-order placed', 'Your order #' . $oid . ' has been submitted.', 'order');
            flash('success', count($created) . ' pre-order(s) placed successfully.');
            redirect('orders.php');
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            flash('danger', $e->getMessage());
            redirect('checkout.php');
        }
    }

    public function farmer_order(): void
    {



        require_role('farmer');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('farmer/orders.php');
        verify_csrf();

        $id = (int)($_POST['order_id'] ?? 0);
        $status = $_POST['status'] ?? '';
        $setTime = (int)($_POST['set_time'] ?? 0);
        $pickupTime = $_POST['pickup_time'] ?? '';
        $uid = current_user()['id'];
        $allowed = ['accepted', 'declined', 'ready', 'completed'];

        if ($setTime === 1) {
            $pdo = db();
            $q = $pdo->prepare("SELECT DISTINCT o.id FROM orders o JOIN order_items oi ON oi.order_id=o.id JOIN products p ON p.id=oi.product_id WHERE o.id=? AND p.farmer_id=? AND o.status IN ('pending','accepted')");
            $q->execute([$id, $uid]);
            if (!$q->fetchColumn() || !$pickupTime) {
                flash('danger', 'Invalid pickup time update.');
                redirect('farmer/orders.php');
            }
            $pdo->prepare("UPDATE orders SET pickup_time=? WHERE id=?")->execute([$pickupTime, $id]);
            $orderQ = $pdo->prepare("SELECT customer_id FROM orders WHERE id=?");
            $orderQ->execute([$id]);
            $customerId = (int)$orderQ->fetchColumn();
            notify_user($customerId, 'Pickup time updated', 'Farmer set order #' . $id . ' pickup time to ' . $pickupTime . '.', 'order');
            flash('success', 'Pickup time updated.');
            redirect('farmer/orders.php');
        }
        if (!in_array($status, $allowed, true)) {
            redirect('farmer/orders.php');
        }

        $pdo = db();
        $q = $pdo->prepare("SELECT DISTINCT o.*
            FROM orders o
            JOIN order_items oi ON oi.order_id = o.id
            JOIN products p ON p.id = oi.product_id
            WHERE o.id = ? AND p.farmer_id = ?");
        $q->execute([$id, $uid]);
        $o = $q->fetch();

        if (!$o) {
            flash('danger', 'Order not found.');
            redirect('farmer/orders.php');
        }

        $valid = ($o['status'] === 'pending' && in_array($status, ['accepted', 'declined'], true))
            || ($o['status'] === 'accepted' && $status === 'ready')
            || ($o['status'] === 'ready' && $status === 'completed');

        if (!$valid) {
            flash('warning', 'Invalid status transition.');
            redirect('farmer/orders.php');
        }

        $pdo->beginTransaction();
        try {
            $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?")->execute([$status, $id]);

            if ($status === 'declined') {
                $items = $pdo->prepare("SELECT product_id, quantity FROM order_items WHERE order_id = ?");
                $items->execute([$id]);
                $restore = $pdo->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
                foreach ($items->fetchAll() as $item) {
                    $restore->execute([(int)$item['quantity'], (int)$item['product_id']]);
                }
            }

            $pdo->commit();
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            flash('danger', 'Could not update the order.');
            redirect('farmer/orders.php');
        }

        notify_user((int)$o['customer_id'], 'Order status updated', 'Order #' . $id . ' is now ' . $status . '.', 'order');
        flash('success', 'Order updated.');
        redirect('farmer/orders.php');
    }

    public function farmer_product(): void
    {
        require_role('farmer');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('farmer/products.php');
        verify_csrf();
        $pdo = db();
        $uid = current_user()['id'];
        $action = $_POST['action'] ?? '';
        $id = (int)($_POST['id'] ?? 0);
        if ($action === 'create' || $action === 'update') {
            $name = trim($_POST['name'] ?? '');
            $cat = (int)($_POST['category_id'] ?? 0);
            $desc = trim($_POST['description'] ?? '');
            $price = (float)($_POST['price'] ?? 0);
            $stock = max(0, (int)($_POST['stock'] ?? 0));
            if ($name === '' || !$cat || $price < 0) {
                flash('danger', 'Please complete all product fields.');
                redirect('farmer/product_form.php' . ($id ? '?id=' . $id : ''));
            }
            $image = null;
            if (!empty($_FILES['image']['name'])) $image = upload_image($_FILES['image'], 'products');
            if ($action === 'create') {
                $pdo->prepare("INSERT INTO products(farmer_id,category_id,name,description,price,stock,image,status,is_sold_out) VALUES(?,?,?,?,?,?,?,'pending',?)")->execute([$uid, $cat, $name, $desc, $price, $stock, $image, $stock < 1 ? 1 : 0]);
                flash('success', 'Product added and sent for admin moderation.');
            } else {
                $check = $pdo->prepare("SELECT * FROM products WHERE id=? AND farmer_id=?");
                $check->execute([$id, $uid]);
                $old = $check->fetch();
                if (!$old) {
                    flash('danger', 'Product not found.');
                    redirect('farmer/products.php');
                }
                $pdo->prepare("UPDATE products SET category_id=?,name=?,description=?,price=?,stock=?,image=? WHERE id=? AND farmer_id=?")->execute([$cat, $name, $desc, $price, $stock, $image ?: $old['image'], $id, $uid]);
                flash('success', 'Product updated.');
            }
            redirect('farmer/products.php');
        }
        if ($action === 'delete') {
            $pdo->prepare("DELETE FROM products WHERE id=? AND farmer_id=?")->execute([$id, $uid]);
            flash('success', 'Product deleted.');
            redirect('farmer/products.php');
        }
        if ($action === 'toggle') {
            $q = $pdo->prepare("SELECT is_sold_out FROM products WHERE id=? AND farmer_id=?");
            $q->execute([$id, $uid]);
            $v = $q->fetchColumn();
            if ($v !== false) $pdo->prepare("UPDATE products SET is_sold_out=? WHERE id=? AND farmer_id=?")->execute([!$v, $id, $uid]);
            flash('success', 'Sold-out state updated.');
            redirect('farmer/products.php');
        }
        redirect('farmer/products.php');
    }

    public function farmer_profile(): void
    {
        require_role('farmer');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('farmer/profile.php');
        verify_csrf();
        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $market = (int)($_POST['market_id'] ?? 0);
        $img = current_user()['profile_image'];
        if (!empty($_FILES['profile_image']['name'])) $img = upload_image($_FILES['profile_image'], 'profiles');
        db()->prepare("UPDATE users SET name=?,phone=?,market_id=?,profile_image=? WHERE id=? AND role='farmer'")->execute([$name, $phone, $market, $img, current_user()['id']]);
        flash('success', 'Profile updated.');
        redirect('farmer/profile.php');
    }

    public function farmer_review(): void
    {
        require_role('farmer');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('farmer/reviews.php');
        verify_csrf();
        $id = (int)($_POST['review_id'] ?? 0);
        $response = trim($_POST['response'] ?? '');
        $q = db()->prepare("UPDATE reviews r JOIN products p ON p.id=r.product_id SET r.farmer_response=? WHERE r.id=? AND p.farmer_id=? AND r.status='approved'");
        $q->execute([$response, $id, current_user()['id']]);
        flash('success', 'Response saved.');
        redirect('farmer/reviews.php');
    }

    public function favorite(): void
    {
        require_role('customer');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('favorites.php');
        verify_csrf();
        $pdo = db();
        $uid = current_user()['id'];
        $product = (int)($_POST['product_id'] ?? 0);
        $farmer = (int)($_POST['farmer_id'] ?? 0);
        $type = $product ? 'product' : 'farmer';
        if ($type === 'product') {
            $q = $pdo->prepare("SELECT id FROM favorite_products WHERE user_id=? AND product_id=?");
            $q->execute([$uid, $product]);
            if ($q->fetch()) {
                $pdo->prepare("DELETE FROM favorite_products WHERE user_id=? AND product_id=?")->execute([$uid, $product]);
            } else {
                $pdo->prepare("INSERT INTO favorite_products(user_id,product_id) VALUES(?,?)")->execute([$uid, $product]);
            }
            redirect($_SERVER['HTTP_REFERER'] ?? 'favorites.php');
        } else {
            $q = $pdo->prepare("SELECT id FROM favorite_farmers WHERE user_id=? AND farmer_id=?");
            $q->execute([$uid, $farmer]);
            if ($q->fetch()) {
                $pdo->prepare("DELETE FROM favorite_farmers WHERE user_id=? AND farmer_id=?")->execute([$uid, $farmer]);
            } else {
                $pdo->prepare("INSERT INTO favorite_farmers(user_id,farmer_id) VALUES(?,?)")->execute([$uid, $farmer]);
            }
            redirect($_SERVER['HTTP_REFERER'] ?? 'favorites.php');
        }
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('login.php');
        }
        verify_csrf();
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $st = db()->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
        $st->execute([$email]);
        $user = $st->fetch();
        if (!$user || !password_verify($password, $user['password'])) {
            flash('danger', 'Invalid email or password.');
            redirect('login.php');
        }
        if ($user['status'] !== 'active') {
            flash('danger', 'Your account is inactive.');
            redirect('login.php');
        }
        if ($user['role'] === 'farmer' && $user['approval_status'] !== 'approved') {
            flash('warning', 'Your farmer account is pending admin approval.');
            redirect('login.php');
        }
        $_SESSION['user_id'] = $user['id'];
        flash('success', 'Welcome back, ' . explode(' ', $user['name'])[0] . '!');
        redirect(role_home($user['role']));
    }

    public function order(): void
    {
        require_role('customer');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('orders.php');
        verify_csrf();
        $pdo = db();
        $uid = current_user()['id'];
        $id = (int)($_POST['order_id'] ?? 0);
        $st = $pdo->prepare("SELECT * FROM orders WHERE id=? AND customer_id=?");
        $st->execute([$id, $uid]);
        $o = $st->fetch();
        if (!$o) {
            flash('danger', 'Order not found.');
            redirect('orders.php');
        }
        $action = $_POST['action'] ?? '';
        if ($action === 'modify' && in_array($o['status'], ['pending', 'accepted'], true)) {
            $date = $_POST['pickup_date'] ?? '';
            $time = $_POST['pickup_time'] ?? '';
            $q = $pdo->prepare("UPDATE orders SET pickup_date=?,pickup_time=? WHERE id=?");
            $q->execute([$date, $time, $id]);
            notify_user($uid, 'Order updated', 'Pickup details for order #' . $id . ' were updated.', 'order');
            flash('success', 'Pickup details updated.');
        } elseif ($action === 'cancel' && in_array($o['status'], ['pending', 'accepted'], true)) {
            $pdo->beginTransaction();
            $items = $pdo->prepare("SELECT product_id,quantity FROM order_items WHERE order_id=?");
            $items->execute([$id]);
            $restore = $pdo->prepare("UPDATE products SET stock=stock+? WHERE id=?");
            foreach ($items->fetchAll() as $it) {
                $restore->execute([(int)$it['quantity'], (int)$it['product_id']]);
            }
            $pdo->prepare("UPDATE orders SET status='cancelled' WHERE id=?")->execute([$id]);
            $pdo->commit();
            notify_user($uid, 'Order cancelled', 'Order #' . $id . ' has been cancelled.', 'order');
            flash('success', 'Order cancelled.');
        }
        redirect('order_view.php?id=' . $id);
    }

    public function profile(): void
    {
        require_role('customer');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('profile.php');
        verify_csrf();
        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        if ($name === '') {
            flash('danger', 'Name is required.');
            redirect('profile.php');
        }
        $uid = current_user()['id'];
        $pdo = db();
        $image = current_user()['profile_image'];
        if (!empty($_FILES['profile_image']['name'])) {
            $image = upload_image($_FILES['profile_image'], 'profiles');
        }
        $pdo->prepare("UPDATE users SET name=?,phone=?,profile_image=? WHERE id=?")->execute([$name, $phone, $image, $uid]);
        flash('success', 'Profile updated.');
        redirect('profile.php');
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('register.php');
        verify_csrf();
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $role = $_POST['role'] ?? 'customer';
        $market = (int)($_POST['market_id'] ?? 0);
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['password_confirmation'] ?? '';
        if (!in_array($role, ['customer', 'farmer'], true) || $name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8 || $password !== $confirm) {
            flash('danger', 'Please enter valid registration details and matching passwords.');
            redirect('register.php');
        }
        $pdo = db();
        $st = $pdo->prepare("SELECT id FROM users WHERE email=?");
        $st->execute([$email]);
        if ($st->fetch()) {
            flash('danger', 'An account with this email already exists.');
            redirect('register.php');
        }
        if ($role === 'farmer' && !$market) {
            flash('danger', 'Farmers must select a market.');
            redirect('register.php');
        }
        $approval = $role === 'farmer' ? 'pending' : 'approved';
        $st = $pdo->prepare("INSERT INTO users(name,email,password,phone,role,market_id,status,approval_status) VALUES(?,?,?,?,?,?,?,?)");
        $st->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $phone, $role, $market ?: null, 'active', $approval]);
        $uid = $pdo->lastInsertId();
        if ($role === 'farmer') notify_user($uid, 'Registration received', 'Your farmer registration is awaiting admin approval.', 'farmer');
        flash('success', $role === 'farmer' ? 'Registration submitted. Wait for admin approval.' : 'Registration successful. You can now login.');
        redirect('login.php');
    }

    public function review(): void
    {
        require_role('customer');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('products.php');
        verify_csrf();
        $pid = (int)($_POST['product_id'] ?? 0);
        $rating = max(1, min(5, (int)($_POST['rating'] ?? 5)));
        $comment = trim($_POST['comment'] ?? '');
        if ($pid < 1 || $comment === '') {
            flash('danger', 'Please provide a review.');
            redirect('product.php?id=' . $pid);
        }
        $pdo = db();
        $check = $pdo->prepare("SELECT COUNT(*) FROM order_items oi JOIN orders o ON o.id=oi.order_id WHERE oi.product_id=? AND o.customer_id=? AND o.status='completed'");
        $check->execute([$pid, current_user()['id']]);
        if (!$check->fetchColumn()) {
            flash('danger', 'You can review a product after a completed order.');
            redirect('product.php?id=' . $pid);
        }
        $dup = $pdo->prepare("SELECT id FROM reviews WHERE product_id=? AND customer_id=?");
        $dup->execute([$pid, current_user()['id']]);
        if ($dup->fetch()) {
            flash('warning', 'You have already reviewed this product.');
            redirect('product.php?id=' . $pid);
        }
        $pdo->prepare("INSERT INTO reviews(product_id,customer_id,rating,comment,status) VALUES(?,?,?,?, 'pending')")->execute([$pid, current_user()['id'], $rating, $comment]);
        flash('success', 'Review submitted for moderation.');
        redirect('product.php?id=' . $pid);
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
        header('Location: ' . url('index.php'));
        exit;
    }
}