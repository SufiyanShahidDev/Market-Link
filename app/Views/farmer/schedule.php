<div class="container py-5"><span class="eyebrow">Inventory planning</span>
    <h1 class="fw-bold mb-4">Weekly Stock</h1><?php foreach ($products as $p): ?><div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold"><?= e($p['name']) ?></h5>
                <form method="post" class="row g-3"><?= csrf_field() ?><input type="hidden" name="product_id" value="<?= $p['id'] ?>"><?php for ($d = 0; $d < 7; $d++): ?><div class="col-6 col-md"><label class="form-label small"><?= $days[$d] ?></label><input type="number" min="0" class="form-control" name="day_<?= $d ?>" value="<?= (int)($schedules[$p['id']][$d] ?? 0) ?>"></div><?php endfor; ?><div class="col-12"><button class="btn btn-primary">Save Schedule</button></div>
                </form>
            </div>
        </div><?php endforeach; ?><?php if (!$products): ?><div class="alert alert-info">Add a product first to manage weekly stock.</div><?php endif; ?>
</div>