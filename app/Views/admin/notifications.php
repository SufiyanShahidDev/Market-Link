<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4"><span class="eyebrow">Communication</span>
                    <h1 class="fw-bold">Notifications</h1>
                    <form method="post"><?= csrf_field() ?><div class="mb-3"><label class="form-label">Audience</label><select name="audience" class="form-select">
                                <option value="all">All active users</option>
                                <option value="customer">Customers</option>
                                <option value="farmer">Farmers</option>
                            </select></div>
                        <div class="mb-3"><label class="form-label">Title</label><input class="form-control" name="title" required></div>
                        <div class="mb-3"><label class="form-label">Message</label><textarea class="form-control" name="message" rows="5" required></textarea></div><button class="btn btn-primary">Send Notification</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>