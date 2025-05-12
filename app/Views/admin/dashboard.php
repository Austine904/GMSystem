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
                    <button onclick="openModal('<?= base_url('admin/users/add') ?>')" class="btn btn-outline-primary d-flex align-items-center gap-2">
                        <i class="bi bi-person-plus"></i> Add User
                    </button>
                    <button onclick="openModal('<?= base_url('admin/vehicles/add') ?>')" class="btn btn-outline-success d-flex align-items-center gap-2">
                        <i class="bi bi-car-front"></i> Register Vehicle
                    </button>
                    <button onclick="openModal('<?= base_url('admin/jobs/create') ?>')" class="btn btn-outline-warning d-flex align-items-center gap-2">
                        <i class="bi bi-briefcase"></i> Create Job
                    </button>
                    <button onclick="openModal('<?= base_url('admin/sublets/add') ?>')" class="btn btn-outline-info d-flex align-items-center gap-2">
                        <i class="bi bi-arrow-repeat"></i> Add Sublet
                    </button>
                    <button onclick="openModal('<?= base_url('admin/lpos/add') ?>')" class="btn btn-outline-danger d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-plus"></i> New LPO
                    </button>
                    <button onclick="openModal('<?= base_url('admin/pettycash/add') ?>')" class="btn btn-outline-dark d-flex align-items-center gap-2">
                        <i class="bi bi-cash"></i> Add Petty Cash
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Structure -->
<div id="actionModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalContent">Loading...</div>
            </div>
        </div>
    </div>
</div>


 <ul class="nav nav-pills mb-4">
        <li class="nav-item">
          <a class="nav-link active" href="#step1" onclick="showStep(1)">Step 1</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#step2" onclick="showStep(2)">Step 2</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#step3" onclick="showStep(3)">Step 3</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#step4" onclick="showStep(4)">Step 4</a>

<script>
   function openModal(url) {
     const modal = new bootstrap.Modal(document.getElementById('actionModal'));
     modal.show();
     
     fetch(url, {
         headers: {
             'X-Requested-With': 'XMLHttpRequest'
         }
     })
     .then(response => response.text())
     .then(data => {
         document.getElementById('modalContent').innerHTML = data;
     })
     .catch(error => {
         document.getElementById('modalContent').innerHTML = "Error loading content.";
         console.error('Error:', error);
     });

     
 }

</script>
<?= $this->endSection(); ?>