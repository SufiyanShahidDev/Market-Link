<div class="container py-5">
    <div class="mb-4"><span class="eyebrow">Saved items</span>
        <h1 class="fw-bold">Favorites</h1>
    </div>
    <h4 class="fw-bold">Favorite Products</h4>
    <div class="row g-4 mb-5"><?php foreach ($products as $x): ?><div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm"><img src="<?= e(product_image($x['image'])) ?>" class="card-img-top product-image">
                    <div class="card-body">
                        <h6 class="fw-bold"><?= e($x['name']) ?></h6><small class="text-secondary"><?= e($x['farmer_name']) ?></small><a class="btn btn-sm btn-primary w-100 mt-3" href="<?= url('product.php?id=' . $x['id']) ?>">View</a>
                    </div>
                </div>
            </div><?php endforeach; ?></div>
    <h4 class="fw-bold">Favorite Farmers</h4>
    <div class="row g-4"><?php foreach ($farmers as $x): ?><div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold"><?= e($x['name']) ?></h6>
                        <div class="text-secondary small"><?= e($x['market_name']) ?></div><a class="btn btn-outline-primary mt-3" href="<?= url('products.php?q=' . urlencode($x['name'])) ?>">View products</a>
                    </div>
                </div>
            </div><?php endforeach; ?></div>
</div>