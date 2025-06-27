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

<!-- Modal for Add/Edit Forms -->
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

<!-- Sublet Details Modal -->
<div class="modal fade" id="subletDetailsModal" tabindex="-1" aria-labelledby="subletDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subletDetailsModalLabel">
                    <i class="bi bi-info-circle me-2"></i> Sublet Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="info-item"><span class="info-label">Sublet ID:</span> <span class="info-value" id="detail_id"></span></div>
                        <div class="info-item"><span class="info-label">Job No:</span> <span class="info-value" id="detail_job_no"></span></div>
                        <div class="info-item"><span class="info-label">Vehicle Reg:</span> <span class="info-value" id="detail_vehicle_reg"></span></div>
                        <div class="info-item"><span class="info-label">Provider:</span> <span class="info-value" id="detail_provider_name"></span></div>
                        <div class="info-item"><span class="info-label">Cost:</span> <span class="info-value" id="detail_cost"></span></div>
                        <div class="info-item"><span class="info-label">Status:</span> <span class="info-value" id="detail_status"></span></div>
                        <div class="info-item"><span class="info-label">Date Sent:</span> <span class="info-value" id="detail_date_sent"></span></div>
                        <div class="info-item"><span class="info-label">Date Returned:</span> <span class="info-value" id="detail_date_returned"></span></div>
                        <div class="info-item"><span class="info-label">Description:</span> <span class="info-value" id="detail_description"></span></div>
                        <div class="info-item"><span class="info-label">Notes:</span> <span class="info-value" id="detail_notes"></span></div>
                        <div class="info-item"><span class="info-label">Created At:</span> <span class="info-value" id="detail_created_at"></span></div>
                        <div class="info-item"><span class="info-label">Last Updated:</span> <span class="info-value" id="detail_updated_at"></span></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom Confirmation Modal for Delete -->
<div class="modal fade custom-confirm-modal" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel"><i class="bi bi-exclamation-triangle me-2"></i> Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                Are you sure you want to delete the selected sublet(s)? This action cannot be undone.
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>
