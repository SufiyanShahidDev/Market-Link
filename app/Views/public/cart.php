<div class="container py-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div><span class="eyebrow">Your selection</span>
            <h1 class="fw-bold">Shopping Cart</h1>
            <p class="text-secondary">Items are reserved as a pre-order and payment is made at pickup.</p>
        </div>
    </div><?php if (!$items): ?><div class="text-center py-5">
            <div class="display-5">🛒</div>
            <h3 class="mt-3">Your cart is empty</h3><a href="<?= url('products.php') ?>" class="btn btn-primary mt-2">Browse Products</a>
        </div><?php else: ?><div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody><?php foreach ($items as $it): $p = $it['product']; ?><tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3"><img class="cart-thumb" src="<?= e(product_image($p['image'])) ?>">
                                                <div>
                                                    <div class="fw-semibold"><?= e($p['name']) ?></div>
                                                    <div class="small text-secondary"><?= e($it['product']['farmer_name']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <form method="post" action="<?= url('actions/cart.php') ?>" class="d-flex gap-1"><?= csrf_field() ?><input type="hidden" name="action" value="update"><input type="hidden" name="product_id" value="<?= $p['id'] ?>"><input class="form-control form-control-sm" style="width:80px" type="number" min="1" max="<?= $p['stock'] ?>" name="quantity" value="<?= $it['qty'] ?>"><button class="btn btn-sm btn-outline-secondary">↻</button></form>
                                        </td>
                                        <td>Rs. <?= money($p['price']) ?></td>
                                        <td class="fw-semibold">Rs. <?= money($it['line']) ?></td>
                                        <td>
                                            <form method="post" action="<?= url('actions/cart.php') ?>"><?= csrf_field() ?><input type="hidden" name="action" value="remove"><input type="hidden" name="product_id" value="<?= $p['id'] ?>"><button class="btn btn-sm btn-outline-danger">Remove</button></form>
                                        </td>
                                    </tr><?php endforeach; ?></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold">Order summary</h5>
                        <div class="d-flex justify-content-between py-2"><span>Subtotal</span><strong>Rs. <?= money($total) ?></strong></div>
                        <div class="small text-secondary mb-3">No online payment is taken. Pay at pickup.</div><a href="<?= url('checkout.php') ?>" class="btn btn-primary w-100">Proceed to Pre-order</a>
                        <form method="post" action="<?= url('actions/cart.php') ?>" class="mt-2"><?= csrf_field() ?><input type="hidden" name="action" value="clear"><button class="btn btn-outline-secondary w-100">Clear Cart</button></form>
                    </div>
                </div>
            </div>
        </div><?php endif; ?>
</div>
