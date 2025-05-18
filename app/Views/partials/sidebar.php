<?php
$currentSegment = service('uri')->getSegment(2);
$session = session();
$name = $session->get('user_name');
$role = $session->get('role');
?>

<div class="sidebar bg-light vh-100 p-3">
    <div class="d-flex align-items-center mb-4">
        <span class="fs-4 fw-bold text-dark">GarageMS</span>
    </div>

    <ul class="nav flex-column gap-3">
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 nav-hover <?= ($currentSegment == 'dashboard') ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>">
                <i class="bi bi-house-door fs-6"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 nav-hover <?= ($currentSegment == 'users') ? 'active' : '' ?>" href="<?= base_url('admin/users') ?>">
                <i class="bi bi-people fs-6"></i>
                <span>Users</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 nav-hover <?= ($currentSegment == 'vehicles') ? 'active' : '' ?>" href="<?= base_url('admin/vehicles') ?>">
                <i class="bi bi-car-front fs-6"></i>
                <span>Vehicles</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 nav-hover <?= ($currentSegment == 'jobs') ? 'active' : '' ?>" href="<?= base_url('admin/jobs') ?>">
                <i class="bi bi-briefcase fs-6"></i>
                <span>Jobs</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 nav-hover <?= ($currentSegment == 'sublets') ? 'active' : '' ?>" href="<?= base_url('admin/sublets') ?>">
                <i class="bi bi-gear fs-6"></i>
                <span>Sublets</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 nav-hover <?= ($currentSegment == 'lpos') ? 'active' : '' ?>" href="<?= base_url('admin/lpos') ?>">
                <i class="bi bi-file-earmark-text fs-6"></i>
                <span>LPOs</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 nav-hover <?= ($currentSegment == 'pettycash') ? 'active' : '' ?>" href="<?= base_url('admin/pettycash') ?>">
                <i class="bi bi-cash-stack fs-6"></i>
                <span>Petty Cash</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 nav-hover <?= ($currentSegment == 'reports') ? 'active' : '' ?>" href="#">
                <i class="bi bi-bar-chart fs-6"></i>
                <span>Reports</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-footer mt-auto">
        <div class="d-flex align-items-center gap-2 p-2 border-top">
            <i class="bi bi-person-circle fs-5"></i>
            <span><strong><?= $name ?></strong> (<?= ucfirst($role) ?>)</span>
        </div>
        <a class="btn btn-outline-dark w-100 mt-2" href="<?= base_url('logout') ?>">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</div>
</div>

<style>
    .sidebar {
        width: 200px;
        position: fixed;
        top: 0;
    }

    .sidebar-footer {
        position: absolute;
        bottom: 20px;
        left: 20px;
        right: 20px;
    }

    .nav-hover {
        color: #000;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .nav-hover i {
        color: #000;
    }

    .nav-hover:hover {
        color: #007bff;
    }

    .nav-hover:hover i {
        color: #007bff;
    }

    .nav-hover.active {
        color: #007bff;
        font-weight: bold;
    }

    .nav-hover.active i {
        color: #007bff;
    }

</style>