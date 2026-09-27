<div class="container py-5"><span class="eyebrow">Administration</span>
    <h1 class="fw-bold mb-4">Manage Customers</h1>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody><?php foreach ($users as $u): ?><tr>
                            <td><?= e($u['name']) ?><br><small><?= e($u['email']) ?></small></td>
                            <td><?= e($u['phone']) ?></td>
                            <td><?= status_badge($u['status']) ?></td>
                            <td>
                                <form method="post" action="<?= url('actions/admin.php') ?>"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $u['id'] ?>"><button class="btn btn-sm <?= $u['status'] === 'active' ? 'btn-danger' : 'btn-success' ?>" name="action" value="<?= $u['status'] === 'active' ? 'deactivate' : 'activate' ?>"><?= $u['status'] === 'active' ? 'Deactivate' : 'Activate' ?></button></form>
                            </td>
                        </tr><?php endforeach; ?></tbody>
            </table>
        </div>
    </div>
</div>