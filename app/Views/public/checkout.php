<div class="container py-5">
    <div class="mb-4"><span class="eyebrow">Final step</span>
        <h1 class="fw-bold">Place Pre-orders</h1>
        <p class="text-secondary">If your cart contains products from multiple farmers, MarketLink creates one pickup order per farmer/market. Payment is collected at pickup.</p>
    </div>
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="post" action="<?= url('actions/checkout.php') ?>"><?= csrf_field() ?><div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Pickup date</label><input type="date" name="pickup_date" min="<?= date('Y-m-d') ?>" class="form-control" required></div>
                            <div class="col-md-6"><label class="form-label">Pickup time</label><input type="time" name="pickup_time" class="form-control" required></div>
                            <div class="col-12"><label class="form-label">Customer note</label><textarea class="form-control" name="note" rows="4" placeholder="Special pickup instructions..."></textarea></div>
                        </div><button class="btn btn-primary btn-lg mt-4">Confirm Pre-orders</button></form>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">Order summary</h5><?php foreach ($groups as $group): $first = $group[0]['product']; ?><div class="border rounded-3 p-3 mb-3">
                            <div class="fw-bold"><?= e($first['farmer_name']) ?></div>
                            <div class="small text-secondary mb-2"><?= e($first['market_name']) ?></div><?php $subtotal = 0;
                                                                                                        foreach ($group as $line): $subtotal += $line['line']; ?><div class="d-flex justify-content-between small py-1"><span><?= e($line['product']['name']) ?> x<?= $line['qty'] ?></span><strong>Rs. <?= money($line['line']) ?></strong></div><?php endforeach; ?><div class="d-flex justify-content-between border-top mt-2 pt-2"><span>Farmer order total</span><strong>Rs. <?= money($subtotal) ?></strong></div>
                        </div><?php endforeach; ?><div class="d-flex justify-content-between pt-2"><span class="fw-semibold">Cart total</span><strong class="fs-5 text-primary">Rs. <?= money($total) ?></strong></div>
                </div>
            </div>
        </div>
    </div>
</div>