<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="container mt-5">
    <h3 class="mb-4">Customers Management</h3>

    <!-- Customers Table -->
    <div class="table-container" style="margin-top: 20px;">
        <div class="table-header d-flex justify-content-between align-items-center mb-3">
            <h4>Customers List</h4>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary d-flex align-items-center gap-2" onclick="openModal('<?= base_url('admin/customers/add') ?>', 'Add New Customer')">
                    <i class="bi bi-person-plus"></i> Add Customer
                </button>
            </div>
        </div>
        <div class="table-responsive rounded">
            <table id="customerTable" class="table table-striped table-bordered" style="width:100%">
                <thead class="table-light">
                    <tr>
                        <th><input type="checkbox" id="select_all_customers"></th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Vehicles</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- DataTables will populate this -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Re-using existing actionModal for Add/Edit forms (from dashboard/user management) -->
<div id="actionModal" class="modal fade" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actionModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalContent" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<?php include('modals.php'); ?>

<?= $this->endSection() ?>