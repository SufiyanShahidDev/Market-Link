<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4"><span class="eyebrow">Account</span>
                    <h2 class="fw-bold">My Profile</h2>
                    <form class="row g-3" method="post" action="<?= url('actions/profile.php') ?>" enctype="multipart/form-data"><?= csrf_field() ?><div class="col-md-6"><label class="form-label">Name</label><input name="name" class="form-control" value="<?= e($user['name']) ?>" required></div>
                        <div class="col-md-6"><label class="form-label">Phone</label><input name="phone" class="form-control" value="<?= e($user['phone']) ?>"></div>
                        <div class="col-12"><label class="form-label">Email</label><input class="form-control" value="<?= e($user['email']) ?>" disabled></div>
                        <div class="col-12"><label class="form-label">Profile image</label><input type="file" class="form-control" name="profile_image" accept="image/*"></div>
                        <div class="col-12"><button class="btn btn-primary">Save Profile</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>