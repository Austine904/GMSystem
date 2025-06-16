<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <h3 class="mb-4">Vehicle Management</h3>

    <!-- Vehicles Table -->
    <div class="table-container" style="margin-top: 20px;">

        <div class="table-header d-flex justify-content-between align-items-center mb-3">
            <h4>Vehicles List</h4>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary d-flex align-items-center gap-2" onclick="$('#addVehicleModal').modal('show')">
                    <i class="bi bi-person-plus"></i> Add Vehicle
                </button>
            </div>
        </div>

        <div class="table-responsive rounded">
            <table id="vehicleTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Registration Number</th>
                        <th>Owner ID</th>
                        <th>Vehicle</th>
                        <th>Vehicle Color</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>

<!-- Modals -->
<?php include('modals.php'); ?>

<?= $this->endSection() ?>