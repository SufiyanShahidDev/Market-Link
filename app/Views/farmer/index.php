<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><span class="eyebrow">Farmer portal</span>
            <h1 class="fw-bold">Vendor Dashboard</h1>
        </div><a href="<?= url('farmer/product_form.php') ?>" class="btn btn-primary">+ Add Product</a>
    </div>
    <div class="row g-4 mb-5"><?php foreach ([['products', 'Products'], ['pending_orders', 'Pending orders'], ['revenue', 'Revenue'], ['reviews', 'Reviews']] as $s): ?><div class="col-6 col-lg-3">
                <div class="stat-card h-100 p-4">
                    <div class="stat-label"><span><?= $s[1] ?></span></div>
                    <div class="display-6 fw-bold"><?= $s[0] === 'revenue' ? 'Rs. ' . money($stats[$s[0]]) : (int)$stats[$s[0]] ?></div>
                    <div class="stat-trend">Live overview</div>
                </div>
            </div><?php endforeach; ?></div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">Best-selling products</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Units</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody><?php foreach ($top as $t): ?><tr>
                                        <td><?= e($t['name']) ?></td>
                                        <td><?= (int)$t['units'] ?></td>
                                        <td>Rs. <?= money($t['revenue']) ?></td>
                                    </tr><?php endforeach; ?></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">Quick links</h5>
                    <div class="d-grid gap-2"><a class="btn btn-outline-primary" href="<?= url('farmer/products.php') ?>">Manage Products</a><a class="btn btn-outline-primary" href="<?= url('farmer/orders.php') ?>">Incoming Orders</a><a class="btn btn-outline-primary" href="<?= url('farmer/schedule.php') ?>">Weekly Stock</a><a class="btn btn-outline-primary" href="<?= url('farmer/reviews.php') ?>">Reviews</a></div>
                </div>
            </div>
        </div>
    </div>
</div>