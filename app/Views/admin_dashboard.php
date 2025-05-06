<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - GMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">GMS Admin</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="admin/users">Users</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Vehicles</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Jobs</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Sublets</a></li>
        <li class="nav-item"><a class="nav-link" href="#">LPOs</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Petty Cash</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Reports</a></li>
      </ul>
      <span class="navbar-text text-light me-3">
        <?= esc($name) ?> (admin)
      </span>
      <a class="btn btn-outline-light" href="<?= base_url('logout') ?>">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <h3>Welcome, <?= esc($name) ?></h3>
    <p>Select an option from the menu to manage the system.</p>
</div>

</body>
</html>
