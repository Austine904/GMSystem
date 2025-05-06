<!DOCTYPE html>
<html>
<head>
    <title>Add New User - Admin Dashboard</title>
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
    <h3>Add New User</h3>
    <form method="POST" action="<?= base_url('admin/users/create') ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="admin">Admin</option>
                <option value="mechanic">Mechanic</option>
                <option value="receptionist">Receptionist</option>
                <option value="customer">Customer</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Save User</button>
    </form>
</div>

</body>
</html>
