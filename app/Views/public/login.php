<div class="auth-shell py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card border-0 shadow-soft p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="brand-mark mx-auto mb-3">
                            <div class="assistant-avatar">
                                <img src="<?= url('assets/img/logo.png') ?>" alt="MarketLink Logo" width="32" height="32" style="width:32px;height:32px;object-fit:contain;display:block;">
                            </div>
                        </div>
                        <h2 class="fw-bold">Welcome back</h2>
                        <p class="text-secondary mb-0">Login to your MarketLink account</p>
                    </div>
                    <form method="post" action="<?= url('actions/login.php') ?>">
                        <?= csrf_field() ?>
                        <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control form-control-lg" required autocomplete="email"></div>
                        <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control form-control-lg" required autocomplete="current-password"></div>
                        <button class="btn btn-primary btn-lg w-100">Login</button>
                    </form>
                    <div class="text-center mt-4"><span class="text-secondary">New to MarketLink?</span> <a href="<?= url('register.php') ?>" class="fw-semibold">Create an account</a></div>
                </div>
            </div>
        </div>
    </div>
</div>