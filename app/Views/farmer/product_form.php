<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4"><span class="eyebrow">Vendor product</span>
                    <h1 class="fw-bold"><?= $id ? 'Edit Product' : 'Add Product' ?></h1>
                    <form method="post" action="<?= url('actions/farmer_product.php') ?>" enctype="multipart/form-data"><input type="hidden" name="action" value="<?= $id ? 'update' : 'create' ?>"><input type="hidden" name="id" value="<?= $id ?>"><?= csrf_field() ?><div class="row g-3">
                            <div class="col-md-8"><label class="form-label">Product name</label><input name="name" class="form-control" value="<?= e($product['name']) ?>" required></div>
                            <div class="col-md-4"><label class="form-label">Category</label><select name="category_id" class="form-select" required><?php foreach ($cats as $c): ?><option value="<?= $c['id'] ?>" <?= $product['category_id'] == $c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
                            <div class="col-md-6"><label class="form-label">Price (PKR)</label><input type="number" step="0.01" min="0" name="price" class="form-control" value="<?= e($product['price']) ?>" required></div>
                            <div class="col-md-6"><label class="form-label">Stock</label><input type="number" min="0" name="stock" class="form-control" value="<?= (int)$product['stock'] ?>" required></div>
                            <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="5"><?= e($product['description']) ?></textarea></div>
                            <div class="col-12"><label class="form-label">Product image</label><input type="file" name="image" class="form-control" accept="image/*">
                                <div class="form-text">JPG, PNG or WEBP. Max 3 MB.</div>
                            </div>
                        </div><button class="btn btn-primary mt-4">Save Product</button><a class="btn btn-outline-secondary mt-4 ms-2" href="<?= url('farmer/products.php') ?>">Cancel</a></form>
                </div>
            </div>
        </div>
    </div>
</div>