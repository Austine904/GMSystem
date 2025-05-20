<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>



<div class="container mt-5"> <h3 class="mb-4">Dashboard</h3>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary"> <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6>Total Users</h6>
                            <h3><?= $userCount ?? '0' ?></h3>
                        </div>
                        <i class="bi bi-people" style="font-size: 2.5rem;"></i> </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6>Vehicles</h6>
                            <h3><?= $vehicleCount ?? '0' ?></h3>
                        </div>
                        <i class="bi bi-truck" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning"> <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6>Jobs in Progress</h6>
                            <h3><?= $activeJobs ?? '0' ?></h3>
                        </div>
                        <i class="bi bi-gear" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6>Pending LPOs</h6>
                            <h3><?= $pendingLPOs ?? '0' ?></h3>
                        </div>
                        <i class="bi bi-file-earmark-text" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-8">
            <div class="card"> <div class="card-header"> <strong>Recent Activity</strong>
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

        <div class="col-md-4">
            <div class="card"> <div class="card-header"> <strong>Quick Actions</strong>
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

<div id="actionModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalContent">
                    <div class="d-flex justify-content-center align-items-center" style="min-height: 100px;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(url) {
        const modalElement = document.getElementById('actionModal');
        const modal = new bootstrap.Modal(modalElement);
        const modalTitle = modalElement.querySelector('.modal-title');
        const modalContent = document.getElementById('modalContent');

        // Set loading state and clear previous content
        modalContent.innerHTML = `
            <div class="d-flex justify-content-center align-items-center" style="min-height: 100px;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        modalTitle.textContent = 'Loading...'; // Default title while loading

        modal.show();

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.text();
        })
        .then(data => {
           
            const urlSegment = url.split('/').pop(); // Get last segment of URL
            modalTitle.textContent = 'Add ' + urlSegment.replace('add', '').replace('create', '').replace('new', '') + ' ';

            modalContent.innerHTML = data;
        })
        .catch(error => {
            modalTitle.textContent = 'Error';
            modalContent.innerHTML = `<div class="alert alert-danger" role="alert">Error loading content: ${error.message}. Please try again.</div>`;
            console.error('Error loading modal content:', error);
        });
    }
</script>
<?= $this->endSection(); ?>
