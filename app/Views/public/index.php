<style>
    /* =========================================================
   MARKETLINK — PREMIUM LANDING PAGE
   ========================================================= */
    :root {
        --ml-primary: #176b4d;
        --ml-primary-dark: #0e4b36;
        --ml-primary-light: #e8f7ef;
        --ml-accent: #f4b942;
        --ml-dark: #10231c;
        --ml-muted: #6b7c75;
        --ml-border: rgba(16, 35, 28, .08);
        --ml-shadow: 0 20px 60px rgba(16, 35, 28, .10);
    }

    body {
        overflow-x: hidden;
    }

    .ml-landing .btn-primary {
        background: var(--ml-primary);
        border-color: var(--ml-primary);
    }

    .ml-landing .btn-primary:hover {
        background: var(--ml-primary-dark);
        border-color: var(--ml-primary-dark);
        transform: translateY(-2px);
    }

    .ml-landing .icon {
        width: 1.15em;
        height: 1.15em;
        vertical-align: -.16em;
    }

    .ml-landing .icon-sm {
        width: 1em;
        height: 1em;
    }

    .ml-landing .hero-section {
        position: relative;
        overflow: hidden;
        min-height: 690px;
        display: flex;
        align-items: center;
        background: radial-gradient(circle at 85% 20%, rgba(244, 185, 66, .20), transparent 25%),
            radial-gradient(circle at 10% 80%, rgba(23, 107, 77, .18), transparent 30%),
            linear-gradient(135deg, #f4fbf7 0%, #fff 55%, #f8fbf9 100%);
        padding: 70px 0 !important;
        border: 0;
    }

    .ml-landing .hero-section::before {
        content: "";
        position: absolute;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        right: -180px;
        top: -180px;
        background: rgba(23, 107, 77, .07);
        animation: mlFloatCircle 8s ease-in-out infinite;
    }

    .ml-landing .hero-section::after {
        content: "";
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        left: -150px;
        bottom: -150px;
        background: rgba(244, 185, 66, .08);
        animation: mlFloatCircle 10s ease-in-out infinite reverse;
    }

    .ml-landing .hero-content {
        position: relative;
        z-index: 2;
    }

    .ml-landing .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: 999px;
        background: rgba(23, 107, 77, .08);
        color: var(--ml-primary);
        border: 1px solid rgba(23, 107, 77, .12);
        font-size: .85rem;
        font-weight: 700;
        animation: mlFadeDown .8s ease both;
    }

    .ml-landing .hero-badge .icon {
        animation: mlPulseIcon 2s ease-in-out infinite;
    }

    .ml-landing .hero-title {
        max-width: 780px;
        font-size: clamp(2.8rem, 6vw, 5.2rem);
        line-height: 1.02;
        letter-spacing: -3px;
        color: var(--ml-dark);
        animation: mlFadeUp .8s .1s ease both;
    }

    .ml-landing .hero-title .highlight {
        color: var(--ml-primary);
        position: relative;
    }

    .ml-landing .hero-title .highlight::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -5px;
        width: 100%;
        height: 8px;
        background: rgba(244, 185, 66, .5);
        border-radius: 20px;
        z-index: -1;
        transform: rotate(-1deg);
    }

    .ml-landing .hero-description {
        max-width: 650px;
        font-size: 1.15rem;
        line-height: 1.8;
        color: var(--ml-muted);
        animation: mlFadeUp .8s .2s ease both;
    }

    .ml-landing .hero-actions {
        animation: mlFadeUp .8s .3s ease both;
    }

    .ml-landing .hero-actions .btn {
        border-radius: 14px;
        font-weight: 700;
        transition: all .3s ease;
    }

    .ml-landing .hero-actions .btn-primary {
        box-shadow: 0 12px 30px rgba(23, 107, 77, .22);
    }

    .ml-landing .hero-actions .btn-primary:hover {
        box-shadow: 0 18px 38px rgba(23, 107, 77, .28);
    }

    .ml-landing .hero-trust {
        margin-top: 25px;
        display: flex;
        align-items: center;
        gap: 14px;
        color: var(--ml-muted);
        font-size: .9rem;
        animation: mlFadeUp .8s .4s ease both;
    }

    .ml-landing .hero-trust-icons {
        display: flex;
    }

    .ml-landing .hero-trust-icons span {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #fff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
        display: grid;
        place-items: center;
        margin-left: -7px;
        color: var(--ml-primary);
    }

    .ml-landing .hero-trust-icons span:first-child {
        margin-left: 0;
    }

    .ml-landing .hero-card-wrapper {
        position: relative;
        z-index: 2;
        animation: mlHeroCardIn 1s .25s cubic-bezier(.16, 1, .3, 1) both;
    }

    .ml-landing .hero-card {
        position: relative;
        overflow: hidden;
        border-radius: 30px !important;
        padding: 30px;
        background: rgba(255, 255, 255, .78);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, .8) !important;
        box-shadow: var(--ml-shadow);
    }

    .ml-landing .hero-card::before {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        right: -70px;
        top: -70px;
        background: rgba(244, 185, 66, .16);
        border-radius: 50%;
    }

    .ml-landing .hero-card-top {
        display: flex;
        align-items: center;
        gap: 15px;
        position: relative;
        z-index: 1;
    }

    .ml-landing .icon-box {
        width: 58px;
        height: 58px;
        border-radius: 17px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        background: var(--ml-primary-light) !important;
        color: var(--ml-primary) !important;
    }

    .ml-landing .hero-card-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--ml-dark);
    }

    .ml-landing .hero-card-subtitle {
        color: var(--ml-muted);
        font-size: .85rem;
        margin-top: 3px;
    }

    .ml-landing .hero-stats {
        margin-top: 28px;
    }

    .ml-landing .stat-mini {
        padding: 20px;
        border-radius: 18px !important;
        background: #f8fbf9;
        border: 1px solid var(--ml-border) !important;
        transition: all .3s ease;
    }

    .ml-landing .stat-mini:hover {
        transform: translateY(-5px);
        background: #fff;
        box-shadow: 0 12px 30px rgba(16, 35, 28, .08);
    }

    .ml-landing .stat-mini strong {
        display: block;
        font-size: 1.7rem;
        color: var(--ml-primary);
    }

    .ml-landing .stat-mini span {
        color: var(--ml-muted);
        font-size: .8rem;
    }

    .ml-landing .payment-note {
        margin-top: 15px;
        border-radius: 17px;
        border: 0;
        background: #fff9e9;
        color: #795b16;
        padding: 15px;
        font-size: .85rem;
    }

    .ml-landing .floating-leaf {
        position: absolute;
        color: var(--ml-primary);
        opacity: .15;
        animation: mlFloatLeaf 5s ease-in-out infinite;
        z-index: 1;
    }

    .ml-landing .leaf-1 {
        right: 5%;
        top: 18%;
    }

    .ml-landing .leaf-2 {
        right: 40%;
        bottom: 12%;
        animation-delay: 1.5s;
    }

    .ml-landing .leaf-3 {
        left: 43%;
        top: 12%;
        animation-delay: 3s;
    }

    .ml-landing .section-space {
        padding: 100px 0;
    }

    .ml-landing .eyebrow {
        display: inline-block;
        color: var(--ml-primary);
        font-size: .78rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .ml-landing .section-title {
        font-size: clamp(2rem, 4vw, 3rem);
        color: var(--ml-dark);
        letter-spacing: -1.5px;
    }

    .ml-landing .section-description {
        color: var(--ml-muted);
        max-width: 620px;
    }

    .ml-landing .product-card {
        border-radius: 22px !important;
        overflow: hidden;
        border: 1px solid var(--ml-border) !important;
        background: #fff;
        transition: transform .35s cubic-bezier(.16, 1, .3, 1), box-shadow .35s ease;
    }

    .ml-landing .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 22px 50px rgba(16, 35, 28, .13) !important;
    }

    .ml-landing .product-image-wrapper {
        position: relative;
        overflow: hidden;
    }

    .ml-landing .product-image {
        height: 230px;
        width: 100%;
        object-fit: cover;
        transition: transform .6s cubic-bezier(.16, 1, .3, 1);
    }

    .ml-landing .product-card:hover .product-image {
        transform: scale(1.07);
    }

    .ml-landing .product-category {
        position: absolute;
        left: 14px;
        top: 14px;
        padding: 7px 11px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .9);
        backdrop-filter: blur(8px);
        color: var(--ml-primary);
        font-size: .72rem;
        font-weight: 800;
    }

    .ml-landing .product-card .card-body {
        padding: 20px;
    }

    .ml-landing .product-card .card-title {
        color: var(--ml-dark);
        font-weight: 800;
    }

    .ml-landing .product-meta {
        color: var(--ml-muted);
        font-size: .8rem;
    }

    .ml-landing .product-price {
        color: var(--ml-primary);
        font-size: 1.1rem;
        font-weight: 800;
    }

    .ml-landing .market-section {
        background: #f7faf8;
    }

    .ml-landing .market-copy {
        padding-right: 30px;
    }

    .ml-landing .market-features {
        margin-top: 25px;
    }

    .ml-landing .market-feature {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 13px;
        color: var(--ml-muted);
        font-size: .9rem;
    }

    .ml-landing .market-feature .icon {
        color: var(--ml-primary);
    }

    .ml-landing .map-wrapper {
        padding: 10px;
        border-radius: 28px;
        background: #fff;
        box-shadow: var(--ml-shadow);
    }

    .ml-landing .map-large {
        height: 460px;
        border-radius: 22px;
        overflow: hidden;
    }

    .ml-landing .cta-section {
        padding: 100px 0;
    }

    .ml-landing .cta-box {
        position: relative;
        overflow: hidden;
        border-radius: 32px;
        padding: 65px 50px;
        background: radial-gradient(circle at 90% 20%, rgba(244, 185, 66, .25), transparent 25%), linear-gradient(135deg, #0e4b36, #176b4d);
        color: #fff;
    }

    .ml-landing .cta-box::before,
    .ml-landing .cta-box::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, .12);
    }

    .ml-landing .cta-box::before {
        width: 350px;
        height: 350px;
        right: -120px;
        top: -180px;
    }

    .ml-landing .cta-box::after {
        width: 250px;
        height: 250px;
        left: -100px;
        bottom: -160px;
    }

    .ml-landing .cta-content {
        position: relative;
        z-index: 2;
    }

    .ml-landing .cta-box h2 {
        font-size: clamp(2rem, 4vw, 3.2rem);
        letter-spacing: -1px;
    }

    .ml-landing .cta-box p {
        color: rgba(255, 255, 255, .75);
        max-width: 600px;
    }

    .ml-landing .cta-box .btn {
        border-radius: 13px;
        padding: 13px 24px;
        font-weight: 700;
    }

    .ml-landing .reveal {
        opacity: 0;
        transform: translateY(35px);
        transition: opacity .75s ease, transform .75s cubic-bezier(.16, 1, .3, 1);
    }

    .ml-landing .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }

    .ml-landing .reveal-delay-1 {
        transition-delay: .1s
    }

    .ml-landing .reveal-delay-2 {
        transition-delay: .2s
    }

    .ml-landing .reveal-delay-3 {
        transition-delay: .3s
    }

    .ml-landing .reveal-delay-4 {
        transition-delay: .4s
    }

    @keyframes mlFadeUp {
        from {
            opacity: 0;
            transform: translateY(25px)
        }

        to {
            opacity: 1;
            transform: translateY(0)
        }
    }

    @keyframes mlFadeDown {
        from {
            opacity: 0;
            transform: translateY(-15px)
        }

        to {
            opacity: 1;
            transform: translateY(0)
        }
    }

    @keyframes mlHeroCardIn {
        from {
            opacity: 0;
            transform: translateY(40px) scale(.96)
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1)
        }
    }

    @keyframes mlFloatCircle {

        0%,
        100% {
            transform: translateY(0)
        }

        50% {
            transform: translateY(20px)
        }
    }

    @keyframes mlFloatLeaf {

        0%,
        100% {
            transform: translateY(0) rotate(0)
        }

        50% {
            transform: translateY(-15px) rotate(8deg)
        }
    }

    @keyframes mlPulseIcon {

        0%,
        100% {
            transform: scale(1)
        }

        50% {
            transform: scale(1.12)
        }
    }

    @media(max-width:991px) {
        .ml-landing .hero-section {
            min-height: auto;
            padding: 70px 0 !important
        }

        .ml-landing .hero-card-wrapper {
            margin-top: 25px
        }

        .ml-landing .market-copy {
            padding-right: 0
        }
    }

    @media(max-width:767px) {

        .ml-landing .section-space,
        .ml-landing .cta-section {
            padding: 70px 0
        }

        .ml-landing .hero-title {
            font-size: 2.7rem;
            letter-spacing: -2px
        }

        .ml-landing .hero-description {
            font-size: 1rem
        }

        .ml-landing .hero-card {
            padding: 22px
        }

        .ml-landing .map-large {
            height: 350px
        }

        .ml-landing .cta-box {
            padding: 45px 25px;
            border-radius: 25px
        }

        .ml-landing .product-image {
            height: 210px
        }
    }

    @media(prefers-reduced-motion:reduce) {

        .ml-landing *,
        .ml-landing *::before,
        .ml-landing *::after {
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: .01ms !important
        }
    }
</style>

<main class="ml-landing">
    <section class="hero-section">
        <?= svg_icon('leaf', 'floating-leaf leaf-1', 'Leaf') ?>
        <?= svg_icon('seedling', 'floating-leaf leaf-2', 'Seedling') ?>
        <?= svg_icon('leaf', 'floating-leaf leaf-3', 'Leaf') ?>
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-7 hero-content">
                    <h1 class="hero-title fw-bold mb-4">Fresh food, <span class="highlight">directly from local farmers.</span></h1>
                    <p class="hero-description mb-4">MarketLink connects customers with local farmers, trusted markets and fresh products — making it simple to discover, pre-order and pick up locally.</p>
                    <div class="hero-actions d-flex flex-wrap gap-3">
                        <a href="<?= url('products.php') ?>" class="btn btn-primary btn-lg px-4 py-3">Browse Products <?= svg_icon('arrow-right', 'icon icon-sm ms-2') ?></a>
                        <a href="<?= url('markets.php') ?>" class="btn btn-outline-primary btn-lg px-4 py-3"><?= svg_icon('location', 'icon icon-sm me-2') ?> Explore Markets</a>
                    </div>
                    <div class="hero-trust">
                        <div class="hero-trust-icons" aria-hidden="true"><span><?= svg_icon('user', 'icon icon-sm') ?></span><span><?= svg_icon('seedling', 'icon icon-sm') ?></span><span><?= svg_icon('location', 'icon icon-sm') ?></span></div><span>Connecting customers, farmers &amp; markets</span>
                    </div>
                </div>
                <div class="col-lg-5 hero-card-wrapper">
                    <div class="hero-card">
                        <div class="hero-card-top">
                            <div class="icon-box"><?= svg_icon('seedling', 'icon') ?></div>
                            <div>
                                <div class="hero-card-title">Farm-to-customer marketplace</div>
                                <div class="hero-card-subtitle">Pre-order today, pickup locally</div>
                            </div>
                        </div>
                        <div class="row g-3 hero-stats">
                            <div class="col-6">
                                <div class="stat-mini"><strong><?= count($markets) ?>+</strong><span>Active markets</span></div>
                            </div>
                            <div class="col-6">
                                <div class="stat-mini"><strong>24/7</strong><span>Online browsing</span></div>
                            </div>
                            <div class="col-12">
                                <div class="payment-note"><?= svg_icon('check', 'icon icon-sm me-2') ?> Payment is collected at pickup, exactly as specified in the project requirements.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-space">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-5 reveal">
                <div><span class="eyebrow">Fresh picks</span>
                    <h2 class="section-title fw-bold mb-2">Featured Products</h2>
                    <p class="section-description mb-0">Discover fresh products from farmers and markets in your local community.</p>
                </div><a href="<?= url('products.php') ?>" class="btn btn-outline-primary px-4">View all <?= svg_icon('arrow-right', 'icon icon-sm ms-2') ?></a>
            </div>
            <div class="row g-4">
                <?php foreach ($products as $index => $product): ?><div class="col-sm-6 col-lg-3 reveal reveal-delay-<?= min($index + 1, 4) ?>">
                        <div class="card h-100 border-0 shadow-sm product-card">
                            <div class="product-image-wrapper"><img src="<?= e(product_image($product['image'])) ?>" class="card-img-top product-image" alt="<?= e($product['name']) ?>" loading="lazy"><span class="product-category"><?= e($product['category_name']) ?></span></div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mt-1 mb-2"><?= e($product['name']) ?></h5>
                                <div class="product-meta mb-3">
                                    <div class="mb-1"><?= svg_icon('user', 'icon icon-sm me-1') ?> <?= e($product['farmer_name']) ?></div>
                                    <div><?= svg_icon('location', 'icon icon-sm me-1') ?> <?= e($product['market_name']) ?></div>
                                </div>
                                <div class="mt-auto d-flex justify-content-between align-items-center gap-2"><strong class="product-price">Rs. <?= money($product['price']) ?></strong><a class="btn btn-sm btn-primary rounded-pill px-3" href="<?= url('product.php?id=' . $product['id']) ?>">Details</a></div>
                            </div>
                        </div>
                    </div><?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="market-section section-space">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5">
                    <div class="market-copy reveal"><span class="eyebrow">Find your pickup point</span>
                        <h2 class="section-title fw-bold mb-3">Markets near your community</h2>
                        <p class="section-description">Explore active market locations and find a convenient pickup point for your next local order.</p>
                        <div class="market-features">
                            <div class="market-feature"><?= svg_icon('check', 'icon icon-sm') ?> View active local markets</div>
                            <div class="market-feature"><?= svg_icon('check', 'icon icon-sm') ?> Find convenient pickup locations</div>
                            <div class="market-feature"><?= svg_icon('check', 'icon icon-sm') ?> Browse farmers and products</div>
                            <div class="market-feature"><?= svg_icon('check', 'icon icon-sm') ?> Plan your pickup using the map</div>
                        </div><a href="<?= url('markets.php') ?>" class="btn btn-primary px-4 py-3 mt-3">Explore All Markets <?= svg_icon('arrow-right', 'icon icon-sm ms-2') ?></a>
                    </div>
                </div>
                <div class="col-lg-7 reveal reveal-delay-2">
                    <div class="map-wrapper">
                        <div id="marketMap" class="map-large"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-box reveal">
                <div class="cta-content"><span class="eyebrow text-warning">Start shopping local</span>
                    <h2 class="fw-bold mt-2 mb-3">Fresh products are closer than you think.</h2>
                    <p class="mb-4">Discover local farmers, explore nearby markets and pre-order fresh products for convenient pickup.</p>
                    <div class="d-flex flex-wrap gap-3"><a href="<?= url('products.php') ?>" class="btn btn-light">Browse Products <?= svg_icon('arrow-right', 'icon icon-sm ms-2') ?></a><a href="<?= url('markets.php') ?>" class="btn btn-outline-light">Find a Market</a></div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    window.marketLinkLandingMarkets = <?= json_encode($markets, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.ml-landing .reveal').forEach(function(el) {
            el.classList.add('active');
        });
        var mapEl = document.getElementById('marketMap');
        if (!mapEl || typeof L === 'undefined') return;
        var markets = window.marketLinkLandingMarkets || [];
        var map = L.map(mapEl, {
            scrollWheelZoom: false
        }).setView([24.8607, 67.0011], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        markets.forEach(function(m) {
            var lat = parseFloat(m.latitude),
                lng = parseFloat(m.longitude);
            if (Number.isFinite(lat) && Number.isFinite(lng)) {
                L.marker([lat, lng]).addTo(map).bindPopup('<strong>' + escapeHtml(m.name) + '</strong><br><small>' + escapeHtml(m.address || '') + '</small>');
            }
        });

        function escapeHtml(value) {
            return String(value).replace(/[&<>\'"]/g, function(c) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    "'": '&#39;',
                    '"': '&quot;'
                } [c];
            });
        }
        setTimeout(function() {
            map.invalidateSize();
        }, 100);
    });
</script>