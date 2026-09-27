<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><span class="eyebrow">Administration</span>
            <h1 class="fw-bold">Admin Dashboard</h1>
        </div><a class="btn btn-primary" href="<?= url('admin/reports.php') ?>">Reports & Analytics</a>
    </div>
    <div class="row g-4 mb-5"><?php foreach ([['customers', 'Customers'], ['farmers', 'Approved farmers'], ['pending_farmers', 'Pending approval'], ['products', 'Products'], ['orders', 'Orders'], ['revenue', 'Revenue']] as $s): ?><div class="col-6 col-xl-2">
                <div class="stat-card h-100 p-3">
                    <div class="stat-label">
                        <span><?= $s[1] ?></span>
                    </div>
                    <div class="fs-4 fw-bold mt-2"><?= $s[0] === 'revenue' ? 'Rs. ' . money($counts[$s[0]]) : (int)$counts[$s[0]] ?></div>
                    <div class="stat-trend">Overview</div>
                </div>
            </div><?php endforeach; ?></div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">Management</h5>
                    <div class="row g-2">
                        <div class="col-md-6"><a class="btn btn-outline-primary w-100" href="<?= url('admin/farmers.php') ?>">Manage Farmers</a></div>
                        <div class="col-md-6"><a class="btn btn-outline-primary w-100" href="<?= url('admin/customers.php') ?>">Manage Customers</a></div>
                        <div class="col-md-6"><a class="btn btn-outline-primary w-100" href="<?= url('admin/markets.php') ?>">Manage Markets</a></div>
                        <div class="col-md-6"><a class="btn btn-outline-primary w-100" href="<?= url('admin/categories.php') ?>">Manage Categories</a></div>
                        <div class="col-md-6"><a class="btn btn-outline-primary w-100" href="<?= url('admin/products.php') ?>">Moderate Products</a></div>
                        <div class="col-md-6"><a class="btn btn-outline-primary w-100" href="<?= url('admin/reviews.php') ?>">Moderate Reviews</a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">Communication</h5><a class="btn btn-primary w-100 mb-2" href="<?= url('admin/notifications.php') ?>">Send Notifications</a>
                    <p class="small text-secondary mb-0">Use role-based notifications for customers, farmers or all users.</p>
                </div>
            </div>
        </div>
    </div>
</div>