<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">Add Market</h5>
                    <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="save"><input class="form-control mb-2" name="name" placeholder="Market name" required><input class="form-control mb-2" name="address" placeholder="Address" required>
                        <div class="row">
                            <div class="col"><input class="form-control mb-2" name="latitude" placeholder="Latitude" required></div>
                            <div class="col"><input class="form-control mb-2" name="longitude" placeholder="Longitude" required></div>
                        </div><select class="form-select mb-3" name="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select><button class="btn btn-primary">Save Market</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">Markets</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody><?php foreach ($markets as $m): ?><tr>
                                        <td><?= e($m['name']) ?><br><small><?= e($m['address']) ?></small></td>
                                        <td><?= status_badge($m['status']) ?></td>
                                        <td>
                                            <form method="post" onsubmit="return confirm('Delete market?')"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $m['id'] ?>"><input type="hidden" name="action" value="delete"><button class="btn btn-sm btn-outline-danger">Delete</button></form>
                                        </td>
                                    </tr><?php endforeach; ?></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>