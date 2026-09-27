<div class="container py-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div><span class="eyebrow">Reporting</span>
            <h1 class="fw-bold">Reports & Analytics</h1>
        </div>
        <div class="d-flex gap-2">
            <form method="post" action="<?= url('actions/admin.php') ?>"><?= csrf_field() ?><input type="hidden" name="action" value="generate_report"><button class="btn btn-primary">Save Current Report</button></form>
            <a href="<?= url('actions/admin.php?action=download_report') ?>" class="btn btn-outline-primary">Download Report</a>
        </div>
    </div>
    <div class="row g-4 mb-5"><?php foreach ([['sales', 'Completed sales', 'Rs. ' . money($stats['sales'])], ['orders', 'Total orders', (int)$stats['orders']], ['customers', 'Customers', (int)$stats['customers']], ['farmers', 'Approved farmers', (int)$stats['farmers']]] as $s): ?><div class="col-md-3">
                <div class="stat-card p-4 h-100"><small class="text-secondary"><?= $s[1] ?></small>
                    <div class="fs-4 fw-bold mt-2"><?= $s[2] ?></div>
                </div>
            </div><?php endforeach; ?></div>
    <div class="row g-4">
        <div class="col-lg-7">
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
                                        <td><?= $t['units'] ?></td>
                                        <td>Rs. <?= money($t['revenue']) ?></td>
                                    </tr><?php endforeach; ?></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">Saved reports</h5><?php foreach ($history as $h): ?><div class="border-bottom py-2 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold"><?= e($h['report_type']) ?></div><small class="text-secondary"><?= e($h['period_start']) ?> to <?= e($h['period_end']) ?> • Rs. <?= money($h['total_sales']) ?></small>
                            </div>
                            <a href="<?= url('actions/admin.php?action=download_saved_report&id=' . $h['id']) ?>" class="btn btn-sm btn-outline-secondary">Download</a>
                        </div><?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>