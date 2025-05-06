<!DOCTYPE html>
<html>
<head>
    <title>Manage Users - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">GMS Admin</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="#">Users</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Vehicles</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Jobs</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Sublets</a></li>
        <li class="nav-item"><a class="nav-link" href="#">LPOs</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Petty Cash</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Reports</a></li>
      </ul>
      <a class="btn btn-outline-light" href="<?= base_url('logout') ?>">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <h3>Manage Users</h3>
    <a href="<?= base_url('admin/users/add') ?>" class="btn btn-primary mb-3">Add New User</a>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= esc($user['id']) ?></td>
                    <td><?= esc($user['name']) ?></td>
                    <td><?= esc($user['phone']) ?></td>
                    <td><?= esc($user['role']) ?></td>
                    <td>
                        <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
