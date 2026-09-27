<div class="container py-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div><span class="eyebrow">Local sellers</span>
            <h1 class="fw-bold">Farmers</h1>
            <p class="text-secondary">Browse approved farmers and their markets.</p>
        </div>
        <form class="d-flex gap-2"><input name="q" value="<?= e($q) ?>" class="form-control" placeholder="Search farmer or market"><button class="btn btn-primary">Search</button></form>
    </div>
    <div class="row g-4"><?php foreach ($farmers as $f): $ps = $pdo->prepare("SELECT COUNT(*) FROM products WHERE farmer_id=? AND status='approved'");
                                $ps->execute([$f['id']]);
                                $pc = (int)$ps->fetchColumn(); ?><div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex gap-3 align-items-center"><img class="avatar" src="<?= e(profile_image($f['profile_image'])) ?>" alt="">
                            <div>
                                <h5 class="mb-1 fw-bold"><?= e($f['name']) ?></h5><span class="text-secondary small"><?= e($f['market_name'] ?: 'Market not assigned') ?></span>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between small"><span>Products</span><strong><?= $pc ?></strong></div>
                        <div class="mt-3 d-flex gap-2"><a href="<?= url('products.php?q=' . urlencode($f['name'])) ?>" class="btn btn-outline-primary flex-fill">View products</a><?php if (current_user() && current_user()['role'] === 'customer'): $fav = $pdo->prepare("SELECT 1 FROM favorite_farmers WHERE user_id=? AND farmer_id=?");
                                                                                                                                                                                    $fav->execute([current_user()['id'], $f['id']]);
                                                                                                                                                                                    $isFav = (bool)$fav->fetchColumn(); ?><form method="post" action="<?= url('actions/favorite.php') ?>"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="farmer_id" value="<?= $f['id'] ?>"><button class="btn btn-outline-primary" title="Favorite farmer"><?= $isFav ? '♥' : '♡' ?></button></form><?php endif; ?></div>
                    </div>
                </div>
            </div><?php endforeach; ?></div>
</div>