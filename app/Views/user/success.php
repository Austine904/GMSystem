<!DOCTYPE html>
<html>
<head>
    <title>Registration Successful</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h5>Registration Successful!</h5>
        </div>
        <div class="card-body">
            <p class="mb-4">The user has been successfully registered in the system.</p>

            <div class="d-flex justify-content-between">
                <a href="<?= base_url('user/add_step1') ?>" class="btn btn-primary">Add Another User</a>
                <a href="<?= base_url('admin/') ?>" class="btn btn-secondary">Go to Dashboard</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
