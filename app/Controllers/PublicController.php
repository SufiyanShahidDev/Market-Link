<?php

namespace App\Controllers;

require_once __DIR__ . '/../Support/bootstrap.php';

class PublicController
{
    public function home(): void
    {
        $pageTitle = 'MarketLink';
        $pdo = db();
        $stmt = $pdo->query("SELECT p.*, c.name AS category_name, u.name AS farmer_name, m.name AS market_name FROM products p LEFT JOIN categories c ON c.id=p.category_id JOIN users u ON u.id=p.farmer_id LEFT JOIN markets m ON m.id=u.market_id WHERE p.status='approved' AND p.is_sold_out=0 AND u.status='active' AND u.approval_status='approved' ORDER BY p.created_at DESC LIMIT 8");
        $products = $stmt->fetchAll();
        $markets = $pdo->query("SELECT * FROM markets WHERE status='active' ORDER BY name LIMIT 6")->fetchAll();
        $useMap = true;

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/public/index.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function login(): void
    {
        $pageTitle = 'MarketLink';
        if (current_user()) redirect(role_home());

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/public/login.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function register(): void
    {
        $pageTitle = 'MarketLink';
        if (current_user()) redirect(role_home());
        $markets = db()->query("SELECT id,name FROM markets WHERE status='active' ORDER BY name")->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/public/register.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function markets(): void
    {
        $pageTitle = 'MarketLink';
        $markets = db()->query("SELECT m.*, COUNT(DISTINCT u.id) farmer_count FROM markets m LEFT JOIN users u ON u.market_id=m.id AND u.role='farmer' AND u.approval_status='approved' WHERE m.status='active' GROUP BY m.id ORDER BY m.name")->fetchAll();
        $useMap = true;

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/public/markets.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function farmers(): void
    {
        $pageTitle = 'MarketLink';
        $pdo = db();
        $q = trim($_GET['q'] ?? '');
        $sql = "SELECT u.*,m.name market_name FROM users u LEFT JOIN markets m ON m.id=u.market_id WHERE u.role='farmer' AND u.status='active' AND u.approval_status='approved'";
        $params = [];
        if ($q !== '') {
            $sql .= " AND (u.name LIKE :q OR m.name LIKE :q)";
            $params['q'] = "%$q%";
        }
        $sql .= " ORDER BY u.name";
        $st = $pdo->prepare($sql);
        $st->execute($params);
        $farmers = $st->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/public/farmers.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function products(): void
    {
        $pageTitle = 'MarketLink';
        $pdo = db();

        $q = trim($_GET['q'] ?? '');
        $category = (int)($_GET['category'] ?? 0);
        $market = (int)($_GET['market'] ?? 0);
        $min = trim($_GET['min'] ?? '');
        $max = trim($_GET['max'] ?? '');

        $sql = "SELECT p.*, c.name category_name, u.name farmer_name, m.name market_name
            FROM products p
            LEFT JOIN categories c ON c.id=p.category_id
            JOIN users u ON u.id=p.farmer_id
            LEFT JOIN markets m ON m.id=u.market_id
            WHERE p.status='approved'
            AND u.status='active'
            AND u.approval_status='approved'";

        $params = [];

        if ($q !== '') {
            $sql .= " AND (p.name LIKE :q1 OR p.description LIKE :q2 OR u.name LIKE :q3)";
            $params['q1'] = "%$q%";
            $params['q2'] = "%$q%";
            $params['q3'] = "%$q%";
        }

        if ($category) {
            $sql .= " AND p.category_id=:category";
            $params['category'] = $category;
        }

        if ($market) {
            $sql .= " AND u.market_id=:market";
            $params['market'] = $market;
        }

        if ($min !== '' && is_numeric($min)) {
            $sql .= " AND p.price>=:min";
            $params['min'] = $min;
        }

        if ($max !== '' && is_numeric($max)) {
            $sql .= " AND p.price<=:max";
            $params['max'] = $max;
        }

        $sql .= " ORDER BY p.created_at DESC";

        $st = $pdo->prepare($sql);
        $st->execute($params);

        $products = $st->fetchAll();

        $categories = $pdo->query(
            "SELECT * FROM categories WHERE status='active' ORDER BY name"
        )->fetchAll();

        $markets = $pdo->query(
            "SELECT * FROM markets WHERE status='active' ORDER BY name"
        )->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/public/products.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function product(): void
    {
        $pageTitle = 'MarketLink';
        $id = (int)($_GET['id'] ?? 0);
        $pdo = db();
        $st = $pdo->prepare("SELECT p.*, c.name category_name, u.name farmer_name, u.email farmer_email, u.id farmer_id, m.name market_name, m.address market_address, m.latitude, m.longitude FROM products p LEFT JOIN categories c ON c.id=p.category_id JOIN users u ON u.id=p.farmer_id LEFT JOIN markets m ON m.id=u.market_id WHERE p.id=? AND p.status='approved'");
        $st->execute([$id]);
        $product = $st->fetch();
        if (!$product) {
            http_response_code(404);
            exit('Product not found.');
        }
        $reviews = $pdo->prepare("SELECT r.*, u.name reviewer_name FROM reviews r JOIN users u ON u.id=r.customer_id WHERE r.product_id=? AND r.status='approved' ORDER BY r.created_at DESC");
        $reviews->execute([$id]);
        $reviews = $reviews->fetchAll();
        $useMap = true;
        $isFav = false;
        if (current_user()) {
            $x = $pdo->prepare("SELECT 1 FROM favorite_products WHERE user_id=? AND product_id=?");
            $x->execute([current_user()['id'], $id]);
            $isFav = (bool)$x->fetchColumn();
        }

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/public/product.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function cart(): void
    {
        $pageTitle = 'MarketLink';
        require_role('customer');
        $pdo = db();
        $cart = $_SESSION['cart'] ?? [];
        $items = [];
        $total = 0;
        if ($cart) {
            $ids = array_keys($cart);
            $in = implode(',', array_fill(0, count($ids), '?'));
            $st = $pdo->prepare("SELECT p.*,u.name farmer_name FROM products p JOIN users u ON u.id=p.farmer_id WHERE p.id IN ($in)");
            $st->execute($ids);
            foreach ($st->fetchAll() as $p) {
                $qty = max(1, (int)$cart[$p['id']]);
                $line = $qty * $p['price'];
                $items[] = ['product' => $p, 'qty' => $qty, 'line' => $line];
                $total += $line;
            }
        }

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/public/cart.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function checkout(): void
    {
        $pageTitle = 'MarketLink';
        require_role('customer');
        $cart = $_SESSION['cart'] ?? [];
        if (!$cart) redirect('cart.php');
        $pdo = db();
        $ids = array_keys($cart);
        $in = implode(',', array_fill(0, count($ids), '?'));
        $st = $pdo->prepare("SELECT p.*,u.name farmer_name,u.id farmer_id,m.name market_name FROM products p JOIN users u ON u.id=p.farmer_id JOIN markets m ON m.id=u.market_id WHERE p.id IN ($in) AND p.status='approved' ORDER BY u.name,p.name");
        $st->execute($ids);
        $products = $st->fetchAll();
        $total = 0;
        $groups = [];
        foreach ($products as $p) {
            $qty = (int)$cart[$p['id']];
            $line = $p['price'] * $qty;
            $total += $line;
            $groups[$p['farmer_id']][] = ['product' => $p, 'qty' => $qty, 'line' => $line];
        }

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/public/checkout.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function orders(): void
    {
        $pageTitle = 'MarketLink';
        require_role('customer');
        $pdo = db();
        $st = $pdo->prepare("SELECT o.*,m.name market_name FROM orders o LEFT JOIN markets m ON m.id=o.market_id WHERE o.customer_id=? ORDER BY o.created_at DESC");
        $st->execute([current_user()['id']]);
        $orders = $st->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/public/orders.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function order_view(): void
    {
        $pageTitle = 'MarketLink';
        require_role('customer');
        $pdo = db();
        $id = (int)($_GET['id'] ?? 0);
        $st = $pdo->prepare("SELECT o.*,m.name market_name,m.address market_address FROM orders o LEFT JOIN markets m ON m.id=o.market_id WHERE o.id=? AND o.customer_id=?");
        $st->execute([$id, current_user()['id']]);
        $order = $st->fetch();
        if (!$order) {
            http_response_code(404);
            exit('Order not found.');
        }
        $it = $pdo->prepare("SELECT oi.*,COALESCE(p.name,oi.product_name) product_name,p.image FROM order_items oi LEFT JOIN products p ON p.id=oi.product_id WHERE oi.order_id=?");
        $it->execute([$id]);
        $items = $it->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/public/order_view.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function favorites(): void
    {
        $pageTitle = 'MarketLink';
        require_role('customer');
        $pdo = db();
        $uid = current_user()['id'];
        $p = $pdo->prepare("SELECT pr.*,u.name farmer_name FROM favorite_products f JOIN products pr ON pr.id=f.product_id JOIN users u ON u.id=pr.farmer_id WHERE f.user_id=? ORDER BY f.created_at DESC");
        $p->execute([$uid]);
        $products = $p->fetchAll();
        $f = $pdo->prepare("SELECT u.*,m.name market_name FROM favorite_farmers ff JOIN users u ON u.id=ff.farmer_id LEFT JOIN markets m ON m.id=u.market_id WHERE ff.user_id=? ORDER BY ff.created_at DESC");
        $f->execute([$uid]);
        $farmers = $f->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/public/favorites.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function profile(): void
    {
        $pageTitle = 'MarketLink';
        require_role('customer');
        $user = current_user();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/public/profile.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function notifications(): void
    {
        $pageTitle = 'MarketLink';
        require_login();
        $st = db()->prepare("SELECT * FROM notifications WHERE user_id=? ORDER BY created_at DESC");
        $st->execute([current_user()['id']]);
        $notes = $st->fetchAll();
        db()->prepare("UPDATE notifications SET is_read=1 WHERE user_id=?")->execute([current_user()['id']]);

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/public/notifications.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    public function assistant(): void
    {
        $pageTitle = 'MarketLink Assistant';
        $askedQuestion = trim((string)($_POST['question'] ?? ''));
        $reply = $this->assistantReply($askedQuestion);

        // The chat UI uses AJAX for quick questions so every click becomes a real
        // user message and receives a server-generated assistant response.
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && (
            (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower((string)$_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || (isset($_SERVER['HTTP_ACCEPT']) && str_contains((string)$_SERVER['HTTP_ACCEPT'], 'application/json'))
        )) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'ok' => true,
                'question' => $askedQuestion,
                'answer' => $reply,
            ], JSON_UNESCAPED_UNICODE);
            return;
        }

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/public/assistant.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }

    private function assistantReply(string $question): string
    {
        $q = strtolower(trim($question));
        if ($q === '') {
            return 'Please type a question and I will help you with MarketLink.';
        }

        $answers = [
            'order' => 'To place an order, open Products, choose a product, add the quantity to your cart, then continue to Checkout. Select your pickup details and confirm the pre-order. Payment is collected at pickup.',
            'payment' => 'MarketLink uses pickup payment for the standard pre-order flow. You place the order online and pay when you collect it from the selected market.',
            'pickup' => 'Your order is picked up from the local market selected during checkout. Check your order details for the selected market, pickup date and pickup time.',
            'farmer' => 'To become a farmer on MarketLink, register using the farmer registration flow, submit your details, and wait for admin approval. After approval you can add and manage products.',
            'cancel' => 'For an eligible pending or accepted order, open your order details and use the cancellation option. If the order has already progressed beyond the allowed status, contact the market or administrator.',
            'review' => 'After an eligible purchase, open the relevant product and submit your rating and comment. Reviews are shown according to the project moderation rules, and approved farmers can respond where supported.',
            'favorite' => 'Use the heart/favorite action on a product or farmer to save it. Your saved items can then be viewed from the Favorites page.',
            'market' => 'Open Markets to see active market locations and pickup points. You can use the map to explore available markets and choose a convenient pickup location during checkout.',
            'register' => 'Use Register to create a customer account. If you want to sell products, use the farmer registration process and wait for approval before publishing products.',
            'login' => 'Open Login and enter your registered email and password. If you do not have an account yet, use Register to create one.',
            'password' => 'If your project includes password recovery, use the available password-reset option from Login. Otherwise, an administrator can help with account recovery according to the project setup.',
            'cart' => 'Open Cart to review quantities and selected products. You can update quantities or remove items before continuing to Checkout.',
            'checkout' => 'At Checkout, review your cart, select the required pickup information, confirm your order details, and submit the pre-order. Payment is collected at pickup.',
            'product' => 'Open Products to browse available items. Use the filters to narrow the list, then open a product to see its details, farmer and market information.',
            'farmer products' => 'Approved farmers can manage their products from the Farmer dashboard. Add a product with its category, price, stock and other required information, then manage it from the products section.',
            'dashboard' => 'Your dashboard gives you quick access to orders, favorites, reviews and notifications. Farmers and administrators have separate dashboards with their own management tools.',
            'notification' => 'Notifications are available from the Notifications page when you are logged in. They can contain updates related to your account or orders.',
            'hello' => 'Hi! 👋 I am the MarketLink Assistant. Ask me about products, orders, checkout, payment, pickup, markets, farmers, favorites or reviews.',
            'help' => 'Sure! I can help with orders, payment, checkout, pickup, markets, products, farmer registration, favorites, reviews, login and dashboards. Choose one of the quick questions or type your own.',
        ];

        // Exact/phrase matching first so preset buttons always get their intended answer.
        $phrases = [
            'how do i place an order' => $answers['order'],
            'how does payment work' => $answers['payment'],
            'where do i pick up my order' => $answers['pickup'],
            'how can i become a farmer' => $answers['farmer'],
            'how do i cancel an order' => $answers['cancel'],
            'how do i leave a review' => $answers['review'],
            'how do favorites work' => $answers['favorite'],
            'how do i find a market' => $answers['market'],
        ];
        foreach ($phrases as $phrase => $answer) {
            if ($q === $phrase || str_contains($q, $phrase)) return $answer;
        }

        // More natural keyword matching for custom questions.
        if (preg_match('/\b(hello|hi|hey|assalam|salam)\b/i', $q)) return $answers['hello'];
        if (preg_match('/\b(help|what can you do)\b/i', $q)) return $answers['help'];
        if (preg_match('/\b(cancel|cancellation)\b/i', $q)) return $answers['cancel'];
        if (preg_match('/\b(payment|pay|cash|money|price)\b/i', $q)) return $answers['payment'];
        if (preg_match('/\b(pickup|pick up|collect|collection)\b/i', $q)) return $answers['pickup'];
        if (preg_match('/\b(farmer|sell|selling|seller)\b/i', $q)) return $answers['farmer'];
        if (preg_match('/\b(review|rating|rate|feedback)\b/i', $q)) return $answers['review'];
        if (preg_match('/\b(favorite|favourite|save|saved)\b/i', $q)) return $answers['favorite'];
        if (preg_match('/\b(market|location|map|where.*market)\b/i', $q)) return $answers['market'];
        if (preg_match('/\b(register|registration|signup|sign up|create account)\b/i', $q)) return $answers['register'];
        if (preg_match('/\b(login|log in|sign in)\b/i', $q)) return $answers['login'];
        if (preg_match('/\b(password|forgot password)\b/i', $q)) return $answers['password'];
        if (preg_match('/\b(cart|basket)\b/i', $q)) return $answers['cart'];
        if (preg_match('/\b(checkout|check out)\b/i', $q)) return $answers['checkout'];
        if (preg_match('/\b(product|products|item|items)\b/i', $q)) return $answers['product'];
        if (preg_match('/\b(dashboard|orders dashboard|my dashboard)\b/i', $q)) return $answers['dashboard'];
        if (preg_match('/\b(notification|notifications)\b/i', $q)) return $answers['notification'];
        if (preg_match('/\b(order|buy|purchase|shopping)\b/i', $q)) return $answers['order'];

        return 'I can help with MarketLink orders, products, checkout, payment, pickup, markets, farmer registration, favorites, reviews, login and dashboards. Try asking a more specific question, for example: “How do I place an order?”';
    }

    public function dashboard(): void
    {
        $pageTitle = 'MarketLink';
        require_role('customer');
        $pdo = db();
        $uid = current_user()['id'];
        $stats = [];
        $q = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE customer_id=?");
        $q->execute([$uid]);
        $stats['orders'] = $q->fetchColumn();
        $q = $pdo->prepare("SELECT COUNT(*) FROM favorite_products WHERE user_id=?");
        $q->execute([$uid]);
        $stats['favorites'] = $q->fetchColumn();
        $q = $pdo->prepare("SELECT COUNT(*) FROM reviews WHERE customer_id=?");
        $q->execute([$uid]);
        $stats['reviews'] = $q->fetchColumn();
        $q = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE user_id=? AND is_read=0");
        $q->execute([$uid]);
        $stats['unread'] = $q->fetchColumn();
        $latest = $pdo->prepare("SELECT * FROM orders WHERE customer_id=? ORDER BY created_at DESC LIMIT 5");
        $latest->execute([$uid]);
        $latest = $latest->fetchAll();

        require __DIR__ . '/../Views/layouts/header.php';
        require __DIR__ . '/../Views/public/dashboard.php';
        require __DIR__ . '/../Views/layouts/footer.php';
    }
}
