<div class="container py-5"><span class="eyebrow">Analytics</span>
    <h1 class="fw-bold mb-4">Revenue Summary</h1>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody><?php foreach ($rows as $r): ?><tr>
                                <td><?= e($r['sale_date']) ?></td>
                                <td>Rs. <?= money($r['revenue']) ?></td>
                            </tr><?php endforeach; ?></tbody>
                </table>
            </div>
        </div>
    </div>
</div>