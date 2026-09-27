<div class="container py-5"><span class="eyebrow">Moderation</span>
    <h1 class="fw-bold mb-4">Moderate Reviews</h1><?php foreach ($reviews as $r): ?><div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div><strong><?= e($r['product_name']) ?></strong>
                        <div class="small text-secondary">By <?= e($r['customer_name']) ?></div>
                    </div>
                    <div><?= status_badge($r['status']) ?></div>
                </div>
                <p class="mt-3 text-secondary mb-3"><?= e($r['comment']) ?></p>
                <form method="post" action="<?= url('actions/admin.php') ?>" class="d-flex gap-2"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $r['id'] ?>"><button name="action" value="approve_review" class="btn btn-sm btn-success">Approve</button><button name="action" value="reject_review" class="btn btn-sm btn-outline-danger">Reject</button></form>
            </div>
        </div><?php endforeach; ?>
</div>