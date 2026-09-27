<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4"><span class="eyebrow">Vendor profile</span>
                    <h1 class="fw-bold">Manage Profile</h1>
                    <form method="post" action="<?= url('actions/farmer_profile.php') ?>" enctype="multipart/form-data"><?= csrf_field() ?><div class="mb-3"><label class="form-label">Name</label><input class="form-control" name="name" value="<?= e($u['name']) ?>" required></div>
                        <div class="mb-3"><label class="form-label">Phone</label><input class="form-control" name="phone" value="<?= e($u['phone']) ?>"></div>
                        <div class="mb-3"><label class="form-label">Market</label><select class="form-select" name="market_id"><?php foreach ($markets as $m): ?><option value="<?= $m['id'] ?>" <?= $u['market_id'] == $m['id'] ? 'selected' : '' ?>><?= e($m['name']) ?></option><?php endforeach; ?></select></div>
                        <div class="mb-3"><label class="form-label">Profile image</label><input type="file" class="form-control" name="profile_image" accept="image/*"></div><button class="btn btn-primary">Save Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>