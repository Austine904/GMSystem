<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Garage Management System' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content {
            flex: 1;
        }
        .card {
            min-height: 200px;
        }
    </style>
</head>
<body>
<div class="wrapper">
<?php $role = session()->get('role'); ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">GMS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if ($role === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link <?= service('uri')->getSegment(2) == 'dashboard' ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link <?= service('uri')->getSegment(2) == 'users' ? 'active' : '' ?>" href="<?= base_url('admin/users') ?>">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/vehicles') ?>">Vehicles</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/jobs') ?>">Jobs</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/sublets') ?>">Sublets</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/lpos') ?>">LPOs</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/pettycash') ?>">Petty Cash</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Reports</a></li>
                <?php endif; ?>
            </ul>
            <span class="navbar-text text-white me-2">Logged in as: <?= ucfirst($role) ?></span>
            <a class="btn btn-outline-light" href="<?= base_url('logout') ?>">Logout</a>
        </div>
    </div>
</nav>

<div class="container content mt-4">
