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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

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

    <!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            GMS
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav gap-4 me-auto mb-2 mb-lg-0">
                <?php if ($role === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 nav-hover" href="<?= base_url('admin/dashboard') ?>">
                            <i class="bi bi-house-door fs-5"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 nav-hover" href="<?= base_url('admin/users') ?>">
                            <i class="bi bi-people fs-5"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 nav-hover" href="<?= base_url('admin/vehicles') ?>">
                            <i class="bi bi-car-front fs-5"></i> Vehicles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 nav-hover" href="<?= base_url('admin/jobs') ?>">
                            <i class="bi bi-briefcase fs-5"></i> Jobs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 nav-hover" href="<?= base_url('admin/sublets') ?>">
                            <i class="bi bi-gear fs-5"></i> Sublets
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 nav-hover" href="<?= base_url('admin/lpos') ?>">
                            <i class="bi bi-file-earmark-text fs-5"></i> LPOs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 nav-hover" href="<?= base_url('admin/pettycash') ?>">
                            <i class="bi bi-cash-stack fs-5"></i> Petty Cash
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 nav-hover" href="#">
                            <i class="bi bi-bar-chart fs-5"></i> Reports
                        </a>
                    </li>
                <?php elseif ($role === 'receptionist'): ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 nav-hover" href="<?= base_url('receptionist/appointments') ?>">
                            <i class="bi bi-calendar-check fs-5"></i> Appointments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 nav-hover" href="<?= base_url('receptionist/vehicles') ?>">
                            <i class="bi bi-car-front fs-5"></i> Vehicles
                        </a>
                    </li>
                <?php elseif ($role === 'customer'): ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 nav-hover" href="<?= base_url('customer/vehicles') ?>">
                            <i class="bi bi-car-front fs-5"></i> My Vehicles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 nav-hover" href="<?= base_url('customer/jobs') ?>">
                            <i class="bi bi-clock-history fs-5"></i> Job History
                        </a>
                    </li>
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

<style>
    .nav-hover {
        position: relative;
        transition: color 0.3s ease;
    }
    .nav-hover.active, .nav-hover:hover {
        color: #007bff;
    }
    .nav-hover i {
        transition: color 0.3s ease;
    }
    .nav-hover.active i, .nav-hover:hover i {
        color: #007bff;
    }
    .nav-hover::after {
        content: "";
        position: absolute;
        width: 0;
        height: 2px;
        background-color: #007bff;
        left: 0;
        bottom: -3px;
        transition: width 0.3s ease;
    }
    .nav-hover.active::after, .nav-hover:hover::after {
        width: 100%;
    }
</style>




    <div class="container content mt-4">