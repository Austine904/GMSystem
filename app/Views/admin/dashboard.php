<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="container mt-8">
    <h3 class="mb-4">Dashboard</h3>

    <!-- Summary Cards -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6>Total Users</h6>
                            <h3><?= $userCount ?? '0' ?></h3>
                        </div>
                        <i class="bi bi-people" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6>Vehicles</h6>
                            <h3><?= $vehicleCount ?? '0' ?></h3>
                        </div>
                        <i class="bi bi-truck" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6>Jobs in Progress</h6>
                            <h3><?= $activeJobs ?? '0' ?></h3>
                        </div>
                        <i class="bi bi-gear" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6>Pending LPOs</h6>
                            <h3><?= $pendingLPOs ?? '0' ?></h3>
                        </div>
                        <i class="bi bi-file-earmark-text" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mt-5">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-light">
                    <strong>Recent Activity</strong>
                </div>
                <ul class="list-group list-group-flush">
                    <?php foreach (($recentActivity ?? []) as $activity): ?>
                        <li class="list-group-item"><?= $activity ?></li>
                    <?php endforeach; ?>
                    <?php if (empty($recentActivity)): ?>
                        <li class="list-group-item text-muted">No recent activity yet.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Quick Actions -->
<div class="col-md-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light">
            <strong>Quick Actions</strong>
        </div>
        <div class="card-body d-grid gap-3">
            <a href="<?= base_url('admin/users/add') ?>" class="btn btn-outline-primary d-flex align-items-center gap-2">
                <i class="bi bi-person-plus"></i> Add User
            </a>
            <a href="<?= base_url('admin/vehicles/add') ?>" class="btn btn-outline-success d-flex align-items-center gap-2">
                <i class="bi bi-car-front"></i> Register Vehicle
            </a>
            <a href="<?= base_url('admin/jobs/create') ?>" class="btn btn-outline-warning d-flex align-items-center gap-2">
                <i class="bi bi-briefcase"></i> Create Job
            </a>
            <a href="<?= base_url('admin/sublets/add') ?>" class="btn btn-outline-info d-flex align-items-center gap-2">
                <i class="bi bi-arrow-repeat"></i> Add Sublet
            </a>
            <a href="<?= base_url('admin/lpos/add') ?>" class="btn btn-outline-danger d-flex align-items-center gap-2">
                <i class="bi bi-file-earmark-plus"></i> New LPO
            </a>
            <a href="<?= base_url('admin/pettycash/add') ?>" class="btn btn-outline-dark d-flex align-items-center gap-2">
                <i class="bi bi-cash"></i> Add Petty Cash
            </a>
        </div>
    </div>
</div>

    </div>
</div>
<style>
    .btn {
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .btn i {
        font-size: 16px;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>


<?= $this->endSection(); ?>
