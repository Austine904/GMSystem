<?php
// Retrieve current URL segment and session data
$currentSegment = service('uri')->getSegment(2);
$session = session();
$name = $session->get('user_name');
$role = $session->get('role');

/**
 * Helper function to determine if a navigation link should be active.
 *
 * @param string $segment The segment name to check against.
 * @param string $currentSegment The current URL segment.
 * @return string Returns 'active' if segments match, otherwise an empty string.
 */
function isActive($segment, $currentSegment) {
    return ($currentSegment == $segment) ? 'active' : '';
}
?>

<style>
    
</style>

<div class="sidebar">
    <div class="d-flex align-items-center mb-4">
        <span class="fs-4 fw-bold text-dark">GarageMS</span>
    </div>

    <nav>
        <ul class="nav flex-column gap-3">
            <li class="nav-item">
                <a class="nav-link nav-hover <?= isActive('dashboard', $currentSegment) ?>"
                   href="<?= base_url('admin/dashboard') ?>"
                   <?= isActive('dashboard', $currentSegment) ? 'aria-current="page"' : '' ?>>
                    <i class="bi bi-house-door fs-6"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php if ($role == 'admin'): // Example of role-based visibility ?>
            <li class="nav-item">
                <a class="nav-link nav-hover <?= isActive('users', $currentSegment) ?>"
                   href="<?= base_url('admin/users') ?>"
                   <?= isActive('users', $currentSegment) ? 'aria-current="page"' : '' ?>>
                    <i class="bi bi-people fs-6"></i>
                    <span>Users</span>
                </a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link nav-hover <?= isActive('vehicles', $currentSegment) ?>"
                   href="<?= base_url('admin/vehicles') ?>"
                   <?= isActive('vehicles', $currentSegment) ? 'aria-current="page"' : '' ?>>
                    <i class="bi bi-car-front fs-6"></i>
                    <span>Vehicles</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-hover <?= isActive('jobs', $currentSegment) ?>"
                   href="<?= base_url('admin/jobs') ?>"
                   <?= isActive('jobs', $currentSegment) ? 'aria-current="page"' : '' ?>>
                    <i class="bi bi-briefcase fs-6"></i>
                    <span>Jobs</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-hover <?= isActive('sublets', $currentSegment) ?>"
                   href="<?= base_url('admin/sublets') ?>"
                   <?= isActive('sublets', $currentSegment) ? 'aria-current="page"' : '' ?>>
                    <i class="bi bi-gear fs-6"></i>
                    <span>Sublets</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-hover <?= isActive('lpos', $currentSegment) ?>"
                   href="<?= base_url('admin/lpos') ?>"
                   <?= isActive('lpos', $currentSegment) ? 'aria-current="page"' : '' ?>>
                    <i class="bi bi-file-earmark-text fs-6"></i>
                    <span>LPOs</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-hover <?= isActive('pettycash', $currentSegment) ?>"
                   href="<?= base_url('admin/pettycash') ?>"
                   <?= isActive('pettycash', $currentSegment) ? 'aria-current="page"' : '' ?>>
                    <i class="bi bi-cash-stack fs-6"></i>
                    <span>Petty Cash</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-hover <?= isActive('reports', $currentSegment) ?>"
                   href="<?= base_url('admin/reports') ?>" <?= isActive('reports', $currentSegment) ? 'aria-current="page"' : '' ?>>
                    <i class="bi bi-bar-chart fs-6"></i>
                    <span>Reports</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer mt-auto">
        <div class="d-flex align-items-center gap-2 p-2 border-top">
            <i class="bi bi-person-circle fs-5"></i>
            <span><strong><?= esc($name) ?></strong> (<?= esc(ucfirst($role)) ?>)</span>
        </div>
        <a class="btn btn-outline-dark w-100 mt-2" href="<?= base_url('logout') ?>">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</div>
