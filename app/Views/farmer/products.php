<div class="container py-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div><span class="eyebrow">Vendor tools</span>
            <h1 class="fw-bold">Manage Products</h1>
        </div><a class="btn btn-primary" href="<?= url('farmer/product_form.php') ?>">Add Product</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody><?php foreach ($products as $p): ?><tr>
                            <td>
                                <div class="d-flex align-items-center gap-2"><img class="cart-thumb" src="<?= e(product_image($p['image'])) ?>"><span class="fw-semibold"><?= e($p['name']) ?></span></div>
                            </td>
                            <td><?= e($p['category_name']) ?></td>
                            <td>Rs. <?= money($p['price']) ?></td>
                            <td><?= (int)$p['stock'] ?></td>
                            <td><?php if ($p['is_sold_out']): ?><span class="badge text-bg-danger">Sold out</span><?php else: ?><?= status_badge($p['status']) ?><?php endif; ?></td>
                            <td class="text-nowrap"><a class="btn btn-sm btn-outline-primary" href="<?= url('farmer/product_form.php?id=' . $p['id']) ?>">Edit</a>
                                <form class="d-inline" method="post" action="<?= url('actions/farmer_product.php') ?>"><?= csrf_field() ?><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= $p['id'] ?>"><button class="btn btn-sm btn-outline-secondary">Sold-out</button></form>
                                <form class="d-inline" method="post" action="<?= url('actions/farmer_product.php') ?>" onsubmit="return confirm('Delete this product?')"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $p['id'] ?>"><button class="btn btn-sm btn-outline-danger">Delete</button></form>
                            </td>
                        </tr><?php endforeach; ?></tbody>
            </table>
        </div>
    </div>
</div>
