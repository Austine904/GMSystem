<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>


<div class="container mt-5">
    <h3>Sublet Management</h3>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <button onclick="openModal('<?= base_url('admin/sublets/add') ?>', 'Add New Sublet')" class="btn btn-outline-primary d-flex align-items-center gap-2">
            <i class="bi bi-plus-circle"></i> Add Sublet
        </button>

        <div class="d-flex gap-2">
            <select class="form-select" id="status-filter" style="min-width: 150px;">
                <option value="">All Statuses</option>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
                <option value="Invoiced">Invoiced</option>
                <option value="Paid">Paid</option>
                <option value="Cancelled">Cancelled</option>
            </select>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('admin/sublets/bulkAction') ?>" id="bulkActionForm">
        <button type="button" class="btn btn-danger mb-3" id="deleteSelectedBtn">
            <i class="bi bi-trash me-1"></i> Delete Selected
        </button>

        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="subletTable">
                <thead class="table-light">
                    <tr>
                        <th><input type="checkbox" id="select_all"></th>
                        <th>ID</th>
                        <th>Job No.</th>
                        <th>Description</th>
                        <th>Provider</th>
                        <th>Cost</th>
                        <th>Status</th>
                        <th>Date Sent</th>
                        <th>Date Returned</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- DataTables will populate this tbody -->
                </tbody>
            </table>
        </div>

        <div id="pagination-links-container"></div>
    </form>
</div>


<?= $this->endSection() ?>
