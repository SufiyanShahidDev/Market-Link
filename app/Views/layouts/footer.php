<?php
$footerUser = current_user();
?>

<footer class="site-footer">
    <div class="container">
        <div class="footer-main">
            <div class="footer-brand">
                <a href="<?= url('home') ?>" class="footer-logo">
                    <img src="<?= url('assets/img/logo.png') ?>" alt="MarketLink logo" width="34" height="34" class="d-inline-block align-text-top">
                    <span>MarketLink</span>
                </a>
                <p>Connecting local farmers with customers through simple, reliable marketplace ordering.</p>
                <div class="footer-socials">
                    <a href="#" aria-label="Facebook"><?= svg_icon("facebook", "icon icon-sm", "Facebook") ?></a>
                    <a href="#" aria-label="Instagram"><?= svg_icon("instagram", "icon icon-sm", "Instagram") ?></a>
                    <a href="#" aria-label="LinkedIn"><?= svg_icon("linkedin", "icon icon-sm", "LinkedIn") ?></a>
                </div>
            </div>

            <div class="footer-column">
                <h6>Explore</h6>
                <a href="<?= url('home') ?>">Home</a>
                <a href="<?= url('products') ?>">Products</a>
                <a href="<?= url('markets') ?>">Markets</a>
                <a href="<?= url('farmers') ?>">Farmers</a>
                <a href="<?= url('assistant') ?>">Assistant</a>
            </div>

            <div class="footer-column">
                <h6>Account</h6>
                <?php if ($footerUser): ?>
                    <a href="<?= url(role_home()) ?>">Dashboard</a>
                    <?php if ($footerUser['role'] === 'customer'): ?>
                        <a href="<?= url('orders') ?>">My Orders</a>
                        <a href="<?= url('favorites') ?>">Favorites</a>
                        <a href="<?= url('cart') ?>">Cart</a>
                        <a href="<?= url('profile') ?>">Profile</a>
                    <?php elseif ($footerUser['role'] === 'farmer'): ?>
                        <a href="<?= url('farmer/products') ?>">My Products</a>
                        <a href="<?= url('farmer/orders') ?>">Orders</a>
                        <a href="<?= url('farmer/sales') ?>">Sales</a>
                        <a href="<?= url('farmer/profile') ?>">Profile</a>
                    <?php else: ?>
                        <a href="<?= url('admin/home') ?>">Admin Panel</a>
                    <?php endif; ?>
                    <a href="<?= url('notifications') ?>">Notifications</a>
                    <a href="<?= url('logout') ?>">Logout</a>
                <?php else: ?>
                    <a href="<?= url('login') ?>">Login</a>
                    <a href="<?= url('register') ?>">Create account</a>
                    <a href="<?= url('login') ?>">Farmer access</a>
                <?php endif; ?>
            </div>

            <div class="footer-column footer-contact">
                <h6>MarketLink</h6>
                <p><?= svg_icon("location", "icon icon-sm") ?> Local marketplace</p>
                <p><?= svg_icon("clock", "icon icon-sm") ?> Pickup-based ordering</p>
                <p><?= svg_icon("leaf", "icon icon-sm") ?> Built for local farmers</p>
            </div>
        </div>

        <div class="footer-bottom">
            <span>&copy; <?= date('Y') ?> MarketLink. All rights reserved.</span>
            <span>TechWiz-7 &middot; Core PHP &middot; MySQL</span>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<?php if ($useMap ?? false): ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<?php endif; ?>
<script src="<?= url('assets/js/app.js') ?>"></script>
</body>
</html>
