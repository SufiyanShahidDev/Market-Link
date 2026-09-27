<div class="auth-shell py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card border-0 shadow-soft p-4 p-md-5">
                    <div class="mb-4"><span class="eyebrow">Get started</span>
                        <h2 class="fw-bold">Create your MarketLink account</h2>
                        <p class="text-secondary">Customers can shop immediately. Farmer accounts require admin approval.</p>
                    </div>
                    <form method="post" action="<?= url('actions/register.php') ?>">
                        <?= csrf_field() ?>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label">Full name</label><input class="form-control" name="name" required></div>
                            <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" name="email" required></div>
                            <div class="col-md-6"><label class="form-label">Phone</label><input class="form-control" name="phone"></div>
                            <div class="col-md-6"><label class="form-label">Account type</label><select class="form-select" name="role" id="roleSelect" required>
                                    <option value="customer">Customer</option>
                                    <option value="farmer">Farmer / Vendor</option>
                                </select></div>
                            <div class="col-md-6"><label class="form-label">Password</label><input type="password" class="form-control" name="password" minlength="8" required></div>
                            <div class="col-md-6"><label class="form-label">Confirm password</label><input type="password" class="form-control" name="password_confirmation" minlength="8" required></div>
                            <div class="col-12" id="marketWrap"><label class="form-label">Your market</label><select class="form-select" name="market_id">
                                    <option value="">Select market (required for farmers)</option><?php foreach ($markets as $m): ?><option value="<?= (int)$m['id'] ?>"><?= e($m['name']) ?></option><?php endforeach; ?>
                                </select></div>
                        </div>
                        <button class="btn btn-primary btn-lg w-100 mt-4">Create Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const roleSelect = document.getElementById('roleSelect'),
        marketWrap = document.getElementById('marketWrap');

    function toggleMarket() {
        marketWrap.style.display = roleSelect.value === 'farmer' ? 'block' : 'none';
    }
    roleSelect.addEventListener('change', toggleMarket);
    toggleMarket();
</script>