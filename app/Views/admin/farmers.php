<div class="container py-5"><span class="eyebrow">Administration</span>
    <h1 class="fw-bold mb-4">Manage Farmers</h1>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Farmer</th>
                        <th>Market</th>
                        <th>Status</th>
                        <th>Approval</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody><?php foreach ($farmers as $f): ?><tr>
                            <td><strong><?= e($f['name']) ?></strong><br><small><?= e($f['email']) ?></small></td>
                            <td><?= e($f['market_name']) ?></td>
                            <td><?= status_badge($f['status']) ?></td>
                            <td><?= status_badge($f['approval_status']) ?></td>
                            <td>
                                <form method="post" action="<?= url('actions/admin.php') ?>" class="d-flex gap-1 flex-wrap"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $f['id'] ?>"><?php if ($f['approval_status'] === 'pending'): ?><button class="btn btn-sm btn-success" name="action" value="approve">Approve</button><?php elseif ($f['approval_status'] === 'approved'): ?><button class="btn btn-sm btn-warning" name="action" value="suspend">Suspend</button><?php else: ?><button class="btn btn-sm btn-success" name="action" value="restore_farmer">Restore</button><?php endif; ?><button class="btn btn-sm btn-outline-danger" name="action" value="deactivate">Deactivate</button></form>
                            </td>
                        </tr><?php endforeach; ?></tbody>
            </table>
        </div>
    </div>
</div>