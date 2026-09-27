<div class="container py-5"><span class="eyebrow">Customer feedback</span>
    <h1 class="fw-bold mb-4">Reviews</h1><?php foreach ($reviews as $r): ?><div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div><strong><?= e($r['product_name']) ?></strong>
                        <div class="small text-secondary"><?= e($r['customer_name']) ?></div>
                    </div><span class="text-warning"><?= str_repeat('★', $r['rating']) . str_repeat('☆', 5 - $r['rating']) ?></span>
                </div>
                <p class="mt-3 mb-3 text-secondary"><?= e($r['comment']) ?></p><?php if ($r['farmer_response']): ?><div class="bg-body-tertiary p-3 rounded small"><strong>Your response:</strong> <?= e($r['farmer_response']) ?></div><?php else: ?><form method="post" action="<?= url('actions/farmer_review.php') ?>"><?= csrf_field() ?><input type="hidden" name="review_id" value="<?= $r['id'] ?>">
                        <div class="input-group"><input name="response" class="form-control" placeholder="Respond to customer" required><button class="btn btn-primary">Respond</button></div>
                    </form><?php endif; ?>
            </div>
        </div><?php endforeach; ?>
</div>