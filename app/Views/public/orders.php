<div class="container py-5">
    <div class="mb-4"><span class="eyebrow">Customer area</span>
        <h1 class="fw-bold">My Orders</h1>
        <p class="text-secondary">Track, modify and cancel your pre-orders.</p>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order</th>
                        <th>Pickup</th>
                        <th>Market</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody><?php foreach ($orders as $o): ?><tr>
                            <td class="fw-semibold">#<?= $o['id'] ?></td>
                            <td><?= e($o['pickup_date']) ?><br><small class="text-secondary"><?= e($o['pickup_time']) ?></small></td>
                            <td><?= e($o['market_name']) ?></td>
                            <td>Rs. <?= money($o['total_amount']) ?></td>
                            <td><?= status_badge($o['status']) ?></td>
                            <td><a class="btn btn-sm btn-outline-primary" href="<?= url('order_view.php?id=' . $o['id']) ?>">View</a></td>
                        </tr><?php endforeach; ?></tbody>
            </table>
        </div><?php if (!$orders): ?><div class="p-5 text-center text-secondary">No orders yet. <a href="<?= url('products.php') ?>">Start shopping</a>.</div><?php endif; ?>
    </div>
</div>