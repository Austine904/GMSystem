<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in and has a role
if (!isset($_SESSION['isLoggedIn']) || !isset($_SESSION['role'])) {

    // Redirect to the login page if not logged in
    header('Location: ' . base_url('login'));
    exit;
}

$role = $_SESSION['role'] ?? 'guest';
$name = $_SESSION['user_name'] ?? 'Guest';
// Set the base URL for the application
$baseURL = base_url();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garage Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        footer {
            background-color: rgb(5, 92, 104);
            color: white;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">GMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if ($role === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/users') ?>">Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/vehicles') ?>">Vehicles</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/jobs') ?>">Jobs</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/sublets') ?>">Sublets</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/lpos') ?>">LPOs</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/pettycash') ?>">Petty Cash</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Reports</a></li>
                    <?php elseif ($role === 'receptionist'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('receptionist/appointments') ?>">Appointments</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('receptionist/vehicles') ?>">Vehicles</a></li>
                    <?php elseif ($role === 'customer'): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('customer/vehicles') ?>">My Vehicles</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('customer/jobs') ?>">Job History</a></li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex">
                    <span class="navbar-text me-3">
                        <strong><?= $name ?></strong> (<?= ucfirst($role) ?>)
                    </span>
                    <a class="btn btn-outline-dark" href="<?= base_url('logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container content mt-4">