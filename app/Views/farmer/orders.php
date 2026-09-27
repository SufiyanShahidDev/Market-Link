<div class="container py-5">
    <div class="mb-4"><span class="eyebrow">Vendor tools</span>
        <h1 class="fw-bold">Incoming Orders</h1>
        <p class="text-secondary">Accept, decline, prepare and complete customer pickup orders.</p>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Pickup</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody><?php foreach ($orders as $o): ?><tr>
                            <td>#<?= $o['id'] ?></td>
                            <td><?= e($o['customer_name']) ?><br><small><?= e($o['phone']) ?></small></td>
                            <td><?= e($o['pickup_date']) ?><br><small><?= e($o['pickup_time']) ?></small></td>
                            <td>Rs. <?= money($o['total_amount']) ?></td>
                            <td><?= status_badge($o['status']) ?></td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    <form method="post" action="<?= url('actions/farmer_order.php') ?>" class="d-flex gap-1 flex-wrap"><?= csrf_field() ?><input type="hidden" name="order_id" value="<?= $o['id'] ?>"><?php if ($o['status'] === 'pending'): ?><button name="status" value="accepted" class="btn btn-sm btn-success">Accept</button><button name="status" value="declined" class="btn btn-sm btn-outline-danger">Decline</button><?php elseif ($o['status'] === 'accepted'): ?><button name="status" value="ready" class="btn btn-sm btn-primary">Ready</button><?php elseif ($o['status'] === 'ready'): ?><button name="status" value="completed" class="btn btn-sm btn-success">Completed</button><?php endif; ?></form><?php if (in_array($o['status'], ['pending', 'accepted'], true)): ?><form method="post" action="<?= url('actions/farmer_order.php') ?>" class="d-flex gap-1"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="order_id" value="<?= $o['id'] ?>"><input type="hidden" name="status" value="<?= e($o['status']) ?>"><input type="hidden" name="set_time" value="1"><input type="time" class="form-control form-control-sm" name="pickup_time" value="<?= e($o['pickup_time']) ?>"><button class="btn btn-sm btn-outline-primary">Set time</button></form><?php endif; ?>
                                </div>
                            </td>
                        </tr><?php endforeach; ?></tbody>
            </table>
        </div>
    </div>
</div>