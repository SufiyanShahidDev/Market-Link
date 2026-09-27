<div class="container py-5">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div><span class="eyebrow">Order details</span>
            <h1 class="fw-bold">Order #<?= $order['id'] ?></h1>
            <p class="text-secondary mb-0">Placed <?= e(date('M d, Y h:i A', strtotime($order['created_at']))) ?></p>
        </div><?= status_badge($order['status']) ?>
    </div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Items</h5><?php foreach ($items as $x): ?><div class="d-flex justify-content-between align-items-center border-bottom py-3">
                            <div class="d-flex gap-3 align-items-center"><img class="cart-thumb" src="<?= e(product_image($x['image'])) ?>">
                                <div>
                                    <div class="fw-semibold"><?= e($x['product_name']) ?></div><small class="text-secondary">Qty <?= (int)$x['quantity'] ?></small>
                                </div>
                            </div><strong>Rs. <?= money($x['subtotal']) ?></strong>
                        </div><?php endforeach; ?><div class="d-flex justify-content-between pt-3"><strong>Total</strong><strong class="text-primary">Rs. <?= money($order['total_amount']) ?></strong></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="fw-bold">Pickup</h5>
                    <div class="small text-secondary">Date</div>
                    <div class="fw-semibold mb-2"><?= e($order['pickup_date']) ?></div>
                    <div class="small text-secondary">Time</div>
                    <div class="fw-semibold mb-2"><?= e($order['pickup_time']) ?></div>
                    <div class="small text-secondary">Market</div>
                    <div class="fw-semibold"><?= e($order['market_name']) ?></div>
                    <div class="small text-secondary"><?= e($order['market_address']) ?></div>
                </div>
            </div><?php if (in_array($order['status'], ['pending', 'accepted'], true)): ?><div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold">Modify pickup</h6>
                        <form method="post" action="<?= url('actions/order.php') ?>"><?= csrf_field() ?><input type="hidden" name="action" value="modify"><input type="hidden" name="order_id" value="<?= $id ?>"><input type="date" name="pickup_date" class="form-control mb-2" value="<?= e($order['pickup_date']) ?>" min="<?= date('Y-m-d') ?>"><input type="time" name="pickup_time" class="form-control mb-3" value="<?= e($order['pickup_time']) ?>"><button class="btn btn-primary w-100">Save Changes</button></form>
                        <form method="post" action="<?= url('actions/order.php') ?>" class="mt-2"><?= csrf_field() ?><input type="hidden" name="action" value="cancel"><input type="hidden" name="order_id" value="<?= $id ?>"><button class="btn btn-outline-danger w-100">Cancel Order</button></form>
                    </div>
                </div><?php endif; ?>
        </div>
    </div>
</div>