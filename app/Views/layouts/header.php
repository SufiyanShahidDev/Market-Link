
<?php
$flash = get_flash();
$user = current_user();
$useMap = $useMap ?? false;
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= e($pageTitle ?? 'MarketLink') ?></title>

    <meta name="description" content="MarketLink multi-vendor local farmer marketplace">
    <link rel="icon" type="image/png" href="<?= url('assets/img/logo.png') ?>">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
<link
        href="<?= url('assets/css/style.css') ?>"
        rel="stylesheet"
    >

    <?php if ($useMap): ?>
        <link
            rel="stylesheet"
            href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
            crossorigin=""
        >
    <?php endif; ?>
</head>

<body>

    <!-- Full UI skeleton loader: shown during initial page load and internal navigation -->
    <div class="page-loader" id="pageLoader" aria-label="Loading MarketLink" aria-live="polite">
        <div class="skeleton-shell">
            <div class="skeleton-nav">
                <div class="skeleton-brand">
                    <span class="skeleton-logo"></span>
                    <span class="skeleton-line skeleton-brand-text"></span>
                </div>
                <div class="skeleton-nav-links">
                    <span class="skeleton-pill"></span><span class="skeleton-pill"></span><span class="skeleton-pill"></span><span class="skeleton-pill small"></span>
                </div>
                <span class="skeleton-avatar"></span>
            </div>

            <main class="skeleton-main">
                <section class="skeleton-hero">
                    <div class="skeleton-hero-copy">
                        <span class="skeleton-line kicker"></span>
                        <span class="skeleton-line title"></span>
                        <span class="skeleton-line title short"></span>
                        <span class="skeleton-line text"></span>
                        <span class="skeleton-line text medium"></span>
                        <div class="skeleton-actions"><span></span><span></span></div>
                    </div>
                    <div class="skeleton-hero-art"></div>
                </section>

                <section class="skeleton-section">
                    <div class="skeleton-heading"><span></span><span></span></div>
                    <div class="skeleton-grid">
                        <div class="skeleton-card"><span></span><i></i><b></b><em></em></div>
                        <div class="skeleton-card"><span></span><i></i><b></b><em></em></div>
                        <div class="skeleton-card"><span></span><i></i><b></b><em></em></div>
                        <div class="skeleton-card"><span></span><i></i><b></b><em></em></div>
                    </div>
                </section>

                <section class="skeleton-dashboard">
                    <div class="skeleton-panel large"></div>
                    <div class="skeleton-panel"></div>
                    <div class="skeleton-panel"></div>
                </section>
            </main>

            <footer class="skeleton-footer">
                <div class="skeleton-footer-brand"></div>
                <div class="skeleton-footer-cols"><span></span><span></span><span></span></div>
            </footer>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light sticky-top">

        <div class="container">

            <a
                class="navbar-brand fw-bold d-flex align-items-center gap-2"
                href="<?= url('home') ?>"
            >
                <img src="<?= url('assets/img/logo.png') ?>" alt="MarketLink logo" width="40" height="40" class="d-inline-block align-text-top">
                <span>MarketLink</span>
            </a>

            <button
                class="navbar-toggler"
                data-bs-toggle="collapse"
                data-bs-target="#mainNav"
            >
                <?= svg_icon("menu", "icon", "Open navigation") ?>
            </button>

            <div id="mainNav" class="collapse navbar-collapse">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item links">
                        <a
                            class="nav-link text-light"
                            href="<?= url('home') ?>"
                        >
                            Home
                        </a>
                    </li>

                    <li class="nav-item links">
                        <a
                            class="nav-link text-light"
                            href="<?= url('products') ?>"
                        >
                            Products
                        </a>
                    </li>

                    <li class="nav-item links">
                        <a
                            class="nav-link text-light"
                            href="<?= url('markets') ?>"
                        >
                            Markets
                        </a>
                    </li>

                    <li class="nav-item links">
                        <a
                            class="nav-link text-light"
                            href="<?= url('farmers') ?>"
                        >
                            Farmers
                        </a>
                    </li>

                    <li class="nav-item links">
                        <a
                            class="nav-link text-light"
                            href="<?= url('assistant') ?>"
                        >
                            Assistant
                        </a>
                    </li>

                    <?php if ($user && $user['role'] === 'customer'): ?>

                        <li class="nav-item links">
                            <a
                                class="nav-link text-light"
                                href="<?= url('orders') ?>"
                            >
                                Orders
                            </a>
                        </li>

                    <?php elseif ($user && $user['role'] === 'farmer'): ?>

                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="<?= url('farmer/orders') ?>"
                            >
                                Orders
                            </a>
                        </li>

                    <?php elseif ($user && $user['role'] === 'admin'): ?>

                        <li class="nav-item">
                            <a
                                class="nav-link"
                                href="<?= url('admin/home') ?>"
                            >
                                Admin
                            </a>
                        </li>

                    <?php endif; ?>

                </ul>

                <div class="d-flex align-items-center gap-2">

                    <?php if ($user): ?>

                        <a
                            class="btn btn-outline-light btn-sm bell-icon"
                            href="<?= url('notifications') ?>"
                        >
                            <?= svg_icon("bell", "icon icon-sm", "Notifications") ?>

                            <?php if (unread_count()): ?>
                                <span class="badge text-bg-danger">
                                    <?= unread_count() ?>
                                </span>
                            <?php endif; ?>

                        </a>

                        <?php if ($user['role'] === 'customer'): ?>

                            <a
                                class="btn btn-primary btn-sm"
                                href="<?= url('cart') ?>"
                            >
                                Cart (<?= count($_SESSION['cart'] ?? []) ?>)
                            </a>

                        <?php endif; ?>

                        <div class="dropdown">

                            <button
                                class="btn btn-primary btn-sm dropdown-toggle"
                                data-bs-toggle="dropdown"
                            >
                                <?= e($user['name']) ?>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">

                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="<?= url(role_home()) ?>"
                                    >
                                        Dashboard
                                    </a>
                                </li>

                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="<?= url(
                                            $user['role'] === 'customer'
                                                ? 'profile.php'
                                                : (
                                                    $user['role'] === 'farmer'
                                                        ? 'farmer/profile.php'
                                                        : 'admin/index.php'
                                                )
                                        ) ?>"
                                    >
                                        Profile / Admin
                                    </a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li>
                                    <a
                                        class="dropdown-item text-danger"
                                        href="<?= url('logout') ?>"
                                    >
                                        Logout
                                    </a>
                                </li>

                            </ul>

                        </div>

                    <?php else: ?>

                        <a
                            class="btn btn-primary btn-sm auth-btn"
                            href="<?= url('login') ?>"
                        >
                            Login
                        </a>

                        <a
                            class="btn btn-primary btn-sm auth-btn"
                            href="<?= url('register') ?>"
                        >
                            Register
                        </a>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </nav>

    <?php if ($flash): ?>

        <div class="container mt-3">

            <div
                class="alert alert-<?= e($flash['type']) ?> alert-dismissible fade show"
                role="alert"
            >

                <?= e($flash['message']) ?>

                <button
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>

            </div>

        </div>

    <?php endif; ?>
