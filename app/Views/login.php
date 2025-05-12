<!DOCTYPE html>
<html>
<head>
    <title>Login - Garage Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f2f2;
        }
        .login-box {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .login-box h2 {
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2 class="text-center">Garage Login</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('login/auth') ?>">
        <div class="mb-3">
            <label for="phone" class="form-label">Company ID</label>
            <input type="text" name="company_id" id="company_id" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

</div>

</body>
</html>
