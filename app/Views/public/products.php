```php
<?php
$products = $products ?? [];
$q = $q ?? '';
$category = $category ?? 0;
$market = $market ?? 0;
$min = $min ?? '';
$max = $max ?? '';
$categories = $categories ?? [];
$markets = $markets ?? [];
?>

<div class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
        <div>
            <span class="eyebrow">Marketplace</span>
            <h1 class="fw-bold mb-1">Browse products</h1>
            <p class="text-secondary mb-0">
                Search and filter products from approved local farmers.
            </p>
        </div>

        <span class="badge text-bg-light border px-3 py-2">
            <?= count($products) ?> results
        </span>
    </div>

    <details class="filter-panel mb-4"
        <?= ($q !== '' || $category || $market || $min !== '' || $max !== '') ? 'open' : '' ?>>

        <summary>
            <span class="d-flex align-items-center gap-2">
                <?= svg_icon('filter', 'icon icon-sm') ?>
                Filters & search
            </span>

            <span class="small text-secondary">Refine products</span>
        </summary>

        <div class="filter-body">
            <form class="row g-3 pt-3" method="get">

                <div class="col-lg-4">
                    <label class="form-label">Search</label>
                    <input
                        name="q"
                        value="<?= e($q) ?>"
                        class="form-control"
                        placeholder="Product, farmer...">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Category</label>

                    <select name="category" class="form-select">
                        <option value="0">All categories</option>

                        <?php foreach ($categories as $c): ?>
                            <option
                                value="<?= $c['id'] ?>"
                                <?= $category === $c['id'] ? 'selected' : '' ?>>
                                <?= e($c['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Market</label>

                    <select name="market" class="form-select">
                        <option value="0">All markets</option>

                        <?php foreach ($markets as $m): ?>
                            <option
                                value="<?= $m['id'] ?>"
                                <?= $market === $m['id'] ? 'selected' : '' ?>>
                                <?= e($m['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Min price</label>
                    <input
                        name="min"
                        value="<?= e($min) ?>"
                        class="form-control"
                        type="number"
                        min="0">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Max price</label>
                    <input
                        name="max"
                        value="<?= e($max) ?>"
                        class="form-control"
                        type="number"
                        min="0">
                </div>

                <div class="col-12 d-flex align-items-end gap-2">
                    <button class="btn btn-primary">
                        Apply Filters
                    </button>

                    <a
                        class="btn btn-outline-secondary"
                        href="<?= url('products.php') ?>">
                        Reset
                    </a>
                </div>

            </form>
        </div>
    </details>

    <div class="row g-4">

        <?php foreach ($products as $p): ?>

            <div class="col-sm-6 col-lg-4 col-xl-3">

                <div class="card h-100 border-0 shadow-sm product-card">

                    <img
                        class="card-img-top product-image"
                        src="<?= e(product_image($p['image'])) ?>"
                        alt="<?= e($p['name']) ?>">

                    <div class="card-body d-flex flex-column">

                        <span class="small text-success fw-semibold">
                            <?= e($p['category_name']) ?>
                        </span>

                        <h5 class="mt-1 mb-1">
                            <?= e($p['name']) ?>
                        </h5>

                        <p class="small text-secondary mb-3">
                            <?= e($p['farmer_name']) ?> •
                            <?= e($p['market_name']) ?>
                        </p>

                        <div class="mt-auto d-flex justify-content-between align-items-center">

                            <strong class="fs-5 text-primary">
                                Rs. <?= money($p['price']) ?>
                            </strong>

                            <a
                                href="<?= url('product.php?id=' . $p['id']) ?>"
                                class="btn btn-sm btn-primary">
                                View
                            </a>

                        </div>
                    </div>

                </div>
            </div>

        <?php endforeach; ?>

    </div>

    <?php if (!$products): ?>

        <div class="text-center py-5">
            <div class="display-6 mb-2">🌱</div>

            <h4>No products found</h4>

            <p class="text-secondary">
                Try a different search or filter.
            </p>
        </div>

    <?php endif; ?>

</div>
```