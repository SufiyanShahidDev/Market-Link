<div class="container py-5"><span class="eyebrow">Moderation</span>
    <h1 class="fw-bold mb-4">Moderate Products</h1>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Farmer</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody><?php foreach ($p as $x): ?><tr>
                            <td><?= e($x['name']) ?><br><small><?= e($x['category_name']) ?></small></td>
                            <td><?= e($x['farmer_name']) ?></td>
                            <td>Rs. <?= money($x['price']) ?></td>
                            <td><?= status_badge($x['status']) ?></td>
                            <td>
                                <form method="post" action="<?= url('actions/admin.php') ?>" class="d-flex gap-1"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $x['id'] ?>"><button class="btn btn-sm btn-success" name="action" value="approve_product">Approve</button><button class="btn btn-sm btn-outline-danger" name="action" value="reject_product">Reject</button></form>
                            </td>
                        </tr><?php endforeach; ?></tbody>
            </table>
        </div>
    </div>
</div>