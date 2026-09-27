<div class="container py-5">
    <div class="mb-4"><span class="eyebrow">Updates</span>
        <h1 class="fw-bold">Notifications</h1>
    </div>
    <div class="list-group shadow-sm"><?php foreach ($notes as $n): ?><div class="list-group-item py-3">
                <div class="d-flex justify-content-between"><strong><?= e($n['title']) ?></strong><small class="text-secondary"><?= e(date('M d, Y h:i A', strtotime($n['created_at']))) ?></small></div>
                <div class="text-secondary mt-1"><?= e($n['message']) ?></div>
            </div><?php endforeach; ?></div><?php if (!$notes): ?><div class="text-center text-secondary py-5">No notifications yet.</div><?php endif; ?>
</div>