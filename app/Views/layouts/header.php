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

<?php
$currentSegment = service('uri')->getSegment(2);
?>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar bg-light vh-100 p-3">
        <div class="d-flex align-items-center mb-4">
            <i class="bi bi-tools fs-4 me-2 text-dark"></i>
            <span class="fs-5 fw-bold text-dark">GarageMS</span>
        </div>
        
        <ul class="nav flex-column gap-3">
            <?php if ($role === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 nav-hover <?= ($currentSegment == 'dashboard') ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>">
                        <i class="bi bi-house-door fs-5 text-dark"></i> 
                        <span class="text-dark">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 nav-hover <?= ($currentSegment == 'users') ? 'active' : '' ?>" href="<?= base_url('admin/users') ?>">
                        <i class="bi bi-people fs-5 text-dark"></i> 
                        <span class="text-dark">Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 nav-hover <?= ($currentSegment == 'vehicles') ? 'active' : '' ?>" href="<?= base_url('admin/vehicles') ?>">
                        <i class="bi bi-car-front fs-5 text-dark"></i> 
                        <span class="text-dark">Vehicles</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 nav-hover <?= ($currentSegment == 'jobs') ? 'active' : '' ?>" href="<?= base_url('admin/jobs') ?>">
                        <i class="bi bi-briefcase fs-5 text-dark"></i> 
                        <span class="text-dark">Jobs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 nav-hover <?= ($currentSegment == 'sublets') ? 'active' : '' ?>" href="<?= base_url('admin/sublets') ?>">
                        <i class="bi bi-gear fs-5 text-dark"></i> 
                        <span class="text-dark">Sublets</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 nav-hover <?= ($currentSegment == 'lpos') ? 'active' : '' ?>" href="<?= base_url('admin/lpos') ?>">
                        <i class="bi bi-file-earmark-text fs-5 text-dark"></i> 
                        <span class="text-dark">LPOs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 nav-hover <?= ($currentSegment == 'pettycash') ? 'active' : '' ?>" href="<?= base_url('admin/pettycash') ?>">
                        <i class="bi bi-cash-stack fs-5 text-dark"></i> 
                        <span class="text-dark">Petty Cash</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 nav-hover <?= ($currentSegment == 'reports') ? 'active' : '' ?>" href="#">
                        <i class="bi bi-bar-chart fs-5 text-dark"></i> 
                        <span class="text-dark">Reports</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>

        <!-- Profile & Logout Fixed at Bottom -->
        <div class="sidebar-footer mt-auto">
            <div class="d-flex align-items-center gap-2 p-2 border-top">
                <i class="bi bi-person-circle fs-5 text-dark"></i>
                <span class="text-dark"><strong><?= $name ?></strong> (<?= ucfirst($role) ?>)</span>
            </div>
            <a class="btn btn-outline-dark w-100 mt-2" href="<?= base_url('logout') ?>">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="p-4" style="margin-left: 250px;">
        <?= $this->renderSection('content'); ?>
    </div>
</div>

<style>
    .sidebar {
        width: 250px;
        position: fixed;
    }
    .sidebar-footer {
        position: absolute;
        bottom: 20px;
        left: 20px;
        right: 20px;
    }
    .nav-hover {
        transition: color 0.3s ease;
    }
    .nav-hover:hover span,
    .nav-hover:hover i {
        color: #007bff;
    }
    .nav-hover.active span,
    .nav-hover.active i {
        color: #007bff;
        font-weight: bold;
    }
    .nav-item {
        margin-bottom: 8px; /* Increased vertical spacing */
    }
    .fs-5 {
        font-size: 0.95rem !important; /* Slightly smaller */
    }
</style>




    <div class="container content mt-4">