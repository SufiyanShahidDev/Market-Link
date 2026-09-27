<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <span class="eyebrow">Customer dashboard</span>
            <h1 class="fw-bold">
                Welcome, <?= e(explode(' ', current_user()['name'])[0]) ?>
            </h1>
        </div>

        <a href="<?= url('products.php') ?>" class="btn btn-primary">
            Shop products
        </a>
    </div>

    <div class="row g-4 mb-5">
        <?php
        $cards = [
            [
                'key' => 'orders',
                'title' => 'Orders',
                'text' => 'Total orders placed'
            ],
            [
                'key' => 'favorites',
                'title' => 'Favorites',
                'text' => 'Saved favorite products'
            ],
            [
                'key' => 'reviews',
                'title' => 'Reviews',
                'text' => 'Reviews you have submitted'
            ],
            [
                'key' => 'unread',
                'title' => 'Unread alerts',
                'text' => 'Unread notifications'
            ]
        ];
        ?>

        <?php foreach ($cards as $card): ?>
            <div class="col-6 col-lg-3">
                <div class="stat-card p-4 h-100">

                    <div class="fs-6 fw-semibold mb-2">
                        <?= e($card['title']) ?>
                    </div>

                    <div class="display-6 fw-bold">
                        <?= (int)$stats[$card['key']] ?>
                    </div>

                    <div class="stat-trend">
                        <?= e($card['text']) ?>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <h5 class="fw-bold">Recent orders</h5>
                <a href="<?= url('orders.php') ?>">View all</a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($latest as $o): ?>
                            <tr>
                                <td>
                                    <a href="<?= url('order_view.php?id=' . $o['id']) ?>">
                                        #<?= $o['id'] ?>
                                    </a>
                                </td>

                                <td>
                                    <?= e($o['pickup_date']) ?>
                                </td>

                                <td>
                                    Rs. <?= money($o['total_amount']) ?>
                                </td>

                                <td>
                                    <?= status_badge($o['status']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
```