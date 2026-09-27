<?php
$product = $product ?? [];
$id = $id ?? 0;
$reviews = $reviews ?? [];
$isFav = $isFav ?? false;
?>

<div class="container py-5">
    <div class="row g-5">

        <div class="col-lg-6">
            <img
                src="<?= e(product_image($product['image'])) ?>"
                class="img-fluid rounded-4 shadow-sm product-detail-image"
                alt="<?= e($product['name']) ?>">
        </div>

        <div class="col-lg-6">
            <span class="badge text-bg-success mb-2">
                <?= e($product['category_name']) ?>
            </span>

            <h1 class="fw-bold">
                <?= e($product['name']) ?>
            </h1>

            <p class="text-secondary mb-1">
                Sold by <strong><?= e($product['farmer_name']) ?></strong>
                • <?= e($product['market_name']) ?>
            </p>

            <div class="display-6 text-primary fw-bold my-3">
                Rs. <?= money($product['price']) ?>
            </div>

            <p class="text-secondary">
                <?= nl2br(e($product['description'])) ?>
            </p>

            <div class="row g-3 my-3">
                <div class="col-6">
                    <div class="info-box">
                        <small>Stock</small>
                        <strong><?= (int)$product['stock'] ?></strong>
                    </div>
                </div>

                <div class="col-6">
                    <div class="info-box">
                        <small>Pickup</small>
                        <strong>At market</strong>
                    </div>
                </div>
            </div>

            <?php if (current_user() && current_user()['role'] === 'customer'): ?>

                <form
                    method="post"
                    action="<?= url('actions/cart.php') ?>"
                    class="d-flex gap-2 align-items-end">
                    <?= csrf_field() ?>

                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?= $id ?>">

                    <div>
                        <label class="form-label">Quantity</label>

                        <input
                            class="form-control"
                            style="width:110px"
                            type="number"
                            min="1"
                            max="<?= max(1, (int)$product['stock']) ?>"
                            value="1"
                            name="quantity">
                    </div>

                    <button class="btn btn-primary btn-lg">
                        Add to Cart
                    </button>

                    <button
                        name="action"
                        value="favorite"
                        class="btn btn-outline-primary btn-lg"
                        formaction="<?= url('actions/favorite.php') ?>">
                        <?= $isFav ? '♥ Favorited' : '♡ Favorite' ?>
                    </button>
                </form>

            <?php elseif (!current_user()): ?>

                <a
                    class="btn btn-primary btn-lg"
                    href="<?= url('login.php') ?>">
                    Login to order
                </a>

            <?php endif; ?>
        </div>
    </div>

    <hr class="my-5">

    <div class="row g-5">

        <div class="col-lg-7">

            <h3 class="fw-bold">
                Reviews & Ratings
            </h3>

            <?php if ($reviews): ?>

                <?php foreach ($reviews as $r): ?>

                    <div class="border rounded-3 p-3 mb-3">

                        <div class="d-flex justify-content-between">

                            <strong>
                                <?= e($r['reviewer_name']) ?>
                            </strong>

                            <span class="text-warning">
                                <?= str_repeat('★', (int)$r['rating']) ?>
                                <?= str_repeat('☆', 5 - (int)$r['rating']) ?>
                            </span>

                        </div>

                        <p class="mb-0 mt-2 text-secondary">
                            <?= e($r['comment']) ?>
                        </p>

                        <?php if (!empty($r['farmer_response'])): ?>

                            <div class="mt-3 p-3 bg-body-tertiary rounded">
                                <small class="fw-bold">
                                    Farmer response
                                </small>

                                <div class="text-secondary small mt-1">
                                    <?= e($r['farmer_response']) ?>
                                </div>
                            </div>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <p class="text-secondary">
                    No reviews yet.
                </p>

            <?php endif; ?>

            <?php if (current_user() && current_user()['role'] === 'customer'): ?>

                <div class="card border-0 shadow-sm mt-4">

                    <div class="card-body">

                        <h5>
                            Leave a review
                        </h5>

                        <form
                            method="post"
                            action="<?= url('actions/review.php') ?>">
                            <?= csrf_field() ?>

                            <input
                                type="hidden"
                                name="product_id"
                                value="<?= $id ?>">

                            <div class="row g-3">

                                <div class="col-md-4">

                                    <select
                                        class="form-select"
                                        name="rating">
                                        <option value="5">5 - Excellent</option>
                                        <option value="4">4 - Good</option>
                                        <option value="3">3 - Average</option>
                                        <option value="2">2 - Poor</option>
                                        <option value="1">1 - Very poor</option>
                                    </select>

                                </div>

                                <div class="col-md-8">

                                    <input
                                        class="form-control"
                                        name="comment"
                                        maxlength="500"
                                        placeholder="Share your experience">

                                </div>

                            </div>

                            <button class="btn btn-primary mt-3">
                                Submit Review
                            </button>

                        </form>

                    </div>
                </div>

            <?php endif; ?>

        </div>

        <div class="col-lg-5">

            <h4 class="fw-bold">
                Pickup Market
            </h4>

            <p class="text-secondary mb-2">
                <?= e($product['market_name']) ?><br>
                <?= e($product['market_address']) ?>
            </p>

            <div id="productMap" class="map-small"></div>

        </div>

    </div>
</div>

<script>
    const pm = L.map('productMap').setView(
        [<?= (float)$product['latitude'] ?>, <?= (float)$product['longitude'] ?>],
        15
    );

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(pm);

    L.marker([
            <?= (float)$product['latitude'] ?>,
            <?= (float)$product['longitude'] ?>
        ])
        .addTo(pm)
        .bindPopup('<?= e($product['market_name']) ?>')
        .openPopup();
</script>