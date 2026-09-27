<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">Add Category</h5>
                    <form method="post"><?= csrf_field() ?><input name="name" class="form-control mb-3" placeholder="e.g. Vegetables" required><button class="btn btn-primary">Save</button></form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold">Categories</h5><?php foreach ($cats as $c): ?><div class="d-flex justify-content-between align-items-center border-bottom py-2"><span><?= e($c['name']) ?></span>
                            <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $c['id'] ?>"><input type="hidden" name="action" value="delete"><button class="btn btn-sm btn-outline-danger">Delete</button></form>
                        </div><?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>