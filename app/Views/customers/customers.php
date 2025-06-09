<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.min.css">
<!-- Font Awesome for icons (if using fas fa-edit, etc.) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>


<style>
    /* Consistent theme variables */
    :root {
        --primary-color: #007bff;
        --primary-hover-color: #0056b3;
        --text-dark: #343a40;
        --bg-light: #f8f9fa;
        --card-bg: #ffffff;
        --shadow-light: rgba(0, 0, 0, 0.1);
        --shadow-medium: rgba(0, 0, 0, 0.15);
        --success-color: #28a745;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
        --info-color: #17a2b8;
        --dark-color: #343a40;
    }

    body {
        font-family: 'Inter', sans-serif;
        color: var(--text-dark);
    }

    .container.mt-5 {
        margin-top: 3rem !important;
    }

    h3 {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 2rem !important;
    }

    /* General Button Styling */
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Specific Button Styles */
    .btn-outline-primary {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }
    .btn-outline-primary:hover {
        background-color: var(--primary-color);
        color: white;
    }
    .btn-outline-secondary {
        border-color: #6c757d;
        color: #6c757d;
    }
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
    .btn-danger {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
        color: white;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #c82333;
    }
    .btn-primary.btn-sm {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        padding: 0.25rem 0.75rem;
    }
    .btn-primary.btn-sm:hover {
        background-color: var(--primary-hover-color);
        border-color: var(--primary-hover-color);
    }
    .btn-info.btn-sm {
        background-color: var(--info-color);
        border-color: var(--info-color);
        color: white;
        padding: 0.25rem 0.75rem;
    }
    .btn-info.btn-sm:hover {
        background-color: #138496; /* Darker info color */
        border-color: #138496;
    }


    /* Form Controls (Search, Select) */
    .form-control, .form-select {
        border-radius: 8px;
        border-color: #ced4da;
        padding: 0.75rem 1rem;
        box-shadow: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }

    /* Table Styling (for DataTables) */
    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        border-radius: 8px;
        border-color: #ced4da;
        padding: 0.5rem 0.75rem;
        box-shadow: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .dataTables_wrapper .dataTables_filter input:focus,
    .dataTables_wrapper .dataTables_length select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }

    .table {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px var(--shadow-light);
        border: none;
        width: 100% !important;
    }
    .table-striped > tbody > tr:nth-of-type(odd) > * {
        background-color: var(--bg-light);
    }
    .table-bordered {
        border: 1px solid rgba(0, 0, 0, 0.08);
    }
    .table-bordered > :not(caption) > * > * {
        border-width: 0 1px 1px 0;
        border-color: rgba(0, 0, 0, 0.08);
    }
    .table-bordered > :not(caption) > * > :first-child {
        border-left-width: 0;
    }
    .table-bordered > :not(caption) > :first-child > * {
        border-top-width: 0;
    }

    .table thead.table-light th {
        /* background-color: var(--primary-color); */
        color: var(--text-dark);
        font-weight: 600;
        border: none;
        /* border-color: var(--primary-color); */
        padding: 1rem 1.25rem;
    }
    .table tbody tr td {
        padding: 0.25rem 1.25rem;
        vertical-align: middle;
    }

    /* DataTables Pagination Styling */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 8px !important;
        margin: 0 5px;
        border: 1px solid rgba(0, 0, 0, 0.1) !important;
        color: var(--primary-color) !important;
        background: none !important;
        transition: all 0.2s ease;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: white !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: rgba(0, 123, 255, 0.1) !important;
        color: var(--primary-hover-color) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        color: #6c757d !important;
        border-color: rgba(0, 0, 0, 0.05) !important;
        cursor: not-allowed;
    }

    /* DataTables Info and Length */
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_length {
        color: var(--text-dark);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
    }

    /* Icon Buttons for Actions */
    .icon-btn {
        background: none;
        border: none;
        padding: 0.5rem;
        cursor: pointer;
        font-size: 1.2rem;
        transition: color 0.2s ease, transform 0.2s ease;
    }
    .icon-btn:hover {
        transform: scale(1.1);
    }
    .icon-btn.text-info:hover { color: #0dcaf0; } /* Bootstrap info */
    .icon-btn.text-primary:hover { color: var(--primary-hover-color); }
    .icon-btn.text-danger:hover { color: #dc3545; } /* Bootstrap danger */


    /* === MODAL STYLING (Modernized) === */
    .modal-backdrop.fade {
        opacity: 0.7;
    }
    .modal.fade .modal-dialog {
        transform: translate(0, -50px);
        opacity: 0;
        transition: transform 0.3s ease-out, opacity 0.3s ease-out;
    }
    .modal.show .modal-dialog {
        transform: translate(0, 0);
        opacity: 1;
    }

    .modal-content {
        border-radius: 15px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.25);
        border: none;
        overflow: hidden;
    }
    .modal-header {
        border-bottom: none;
        padding: 1.5rem;
        background-color: var(--card-bg);
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .modal-title {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.2rem;
    }
    .modal-body {
        padding: 1.5rem;
        color: var(--text-dark);
    }
    .modal-footer {
        border-top: none;
        padding: 1rem 1.5rem;
        background-color: var(--card-bg);
    }
    .modal-footer .btn {
        padding: 0.6rem 1.2rem;
        font-size: 0.95rem;
    }

    /* Customer Details Modal Specifics */
    #customerDetailsModal .modal-dialog {
        max-width: 900px;
    }
    #customerDetailsModal .modal-header {
        background: linear-gradient(90deg, var(--primary-color), var(--primary-hover-color)) !important;
        color: white !important;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    #customerDetailsModal .modal-header .modal-title {
        color: white !important;
    }
    #customerDetailsModal .modal-header .btn-close {
        filter: invert(1);
    }

    #customerDetailsModal .info-item {
        margin-bottom: 0.75rem;
        text-align: left;
    }
    #customerDetailsModal .info-label {
        font-weight: 600;
        color: var(--text-dark);
        display: block;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }
    #customerDetailsModal .info-value {
        color: #555;
        font-size: 1rem;
    }

    /* Tab Styling within Customer Details Modal */
    #customerDetailsModal .nav-tabs {
        border-bottom: none;
        margin-bottom: 1.5rem;
    }
    #customerDetailsModal .nav-tabs .nav-item .nav-link {
        border: none;
        border-radius: 8px 8px 0 0;
        background-color: transparent;
        color: var(--text-dark);
        font-weight: 500;
        padding: 0.75rem 1.25rem;
        transition: all 0.2s ease;
        position: relative;
    }
    #customerDetailsModal .nav-tabs .nav-item .nav-link:hover {
        color: var(--primary-color);
        background-color: rgba(0, 123, 255, 0.05);
    }
    #customerDetailsModal .nav-tabs .nav-item .nav-link.active {
        color: var(--primary-color);
        background-color: var(--card-bg);
        font-weight: 600;
    }
    #customerDetailsModal .nav-tabs .nav-item .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: var(--primary-color);
        border-radius: 2px 2px 0 0;
    }
    #customerDetailsModal .tab-content {
        background-color: var(--card-bg);
        border-radius: 0 0 15px 15px;
        padding: 1.5rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.08);
        border-top: none;
    }

    /* Custom Confirmation Modal */
    .custom-confirm-modal .modal-footer .btn {
        min-width: 80px;
    }
    .custom-confirm-modal .modal-body {
        font-size: 1.1rem;
        color: var(--text-dark);
    }
    .custom-confirm-modal .modal-header {
        background-color: var(--danger-color);
        color: white;
    }
    .custom-confirm-modal .modal-header .modal-title {
        color: white;
    }
    .custom-confirm-modal .modal-header .btn-close {
        filter: invert(1);
    }

    /* Customer Details Modal Specifics */
    #customerDetailsModal .customer-profile-picture {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary-color);
        margin: 0 auto 1rem;
        display: block; /* Center the image */
    }
    #customerDetailsModal .customer-name-heading {
        font-size: 1.8rem;
        font-weight: 700;
        text-align: center;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }
    #customerDetailsModal .profile-contact-info {
        text-align: center;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
        color: #555;
    }
    #customerDetailsModal .profile-contact-info i {
        margin-right: 0.5rem;
        color: var(--primary-color);
    }
</style>

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

<!-- Customer Details Modal - REVAMPED -->
<div class="modal fade" id="customerDetailsModal" tabindex="-1" aria-labelledby="customerDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerDetailsModalLabel">
                    <i class="bi bi-person-vcard me-2"></i> Customer Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Left Column: Customer Summary -->
                    <div class="col-md-4 text-center">
                        <img id="customer-profile-picture" src="https://placehold.co/100x100/cccccc/333333?text=CS" class="customer-profile-picture mb-3" alt="Customer Photo">
                        <h5 class="customer-name-heading" id="customer-fullname-modal"></h5>
                        <div class="profile-contact-info">
                            <p class="mb-1"><i class="bi bi-phone"></i> <span id="customer-phone-modal"></span></p>
                            <p class="mb-1"><i class="bi bi-envelope"></i> <span id="customer-email-modal"></span></p>
                            <p class="mb-1"><i class="bi bi-house"></i> <span id="customer-address-modal"></span></p>
                        </div>
                        <div class="info-item border-top pt-3">
                            <span class="info-label">Member Since:</span>
                            <span class="info-value" id="customer-created-at"></span>
                        </div>
                    </div>

                    <!-- Right Column: Tabs for Detailed Info -->
                    <div class="col-md-8">
                        <ul class="nav nav-tabs mb-3" id="customerDetailsTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="customer-overview-tab" data-bs-toggle="tab" data-bs-target="#customer-overview" type="button" role="tab" aria-controls="customer-overview" aria-selected="true">Overview</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="customer-vehicles-tab" data-bs-toggle="tab" data-bs-target="#customer-vehicles" type="button" role="tab" aria-controls="customer-vehicles" aria-selected="false">Vehicles Owned</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="customer-jobs-tab" data-bs-toggle="tab" data-bs-target="#customer-jobs" type="button" role="tab" aria-controls="customer-jobs" aria-selected="false">Job History</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="customer-invoices-tab" data-bs-toggle="tab" data-bs-target="#customer-invoices" type="button" role="tab" aria-controls="customer-invoices" aria-selected="false">Invoices</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="customer-communication-tab" data-bs-toggle="tab" data-bs-target="#customer-communication" type="button" role="tab" aria-controls="customer-communication" aria-selected="false">Communication Log</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="customerDetailsTabContent">
                            <!-- Overview Tab -->
                            <div class="tab-pane fade show active" id="customer-overview" role="tabpanel" aria-labelledby="customer-overview-tab">
                                <h6 class="mb-3 text-secondary">Customer Contact & Basic Info</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-item"><span class="info-label">Full Name:</span> <span class="info-value" id="overview_fullname"></span></div>
                                        <div class="info-item"><span class="info-label">Phone:</span> <span class="info-value" id="overview_phone"></span></div>
                                        <div class="info-item"><span class="info-label">Email:</span> <span class="info-value" id="overview_email"></span></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item"><span class="info-label">Address:</span> <span class="info-value" id="overview_address"></span></div>
                                        <div class="info-item"><span class="info-label">Account ID:</span> <span class="info-value" id="overview_id"></span></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Vehicles Owned Tab -->
                            <div class="tab-pane fade" id="customer-vehicles" role="tabpanel" aria-labelledby="customer-vehicles-tab">
                                <h6 class="mb-3 text-secondary">Registered Vehicles</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Reg No.</th>
                                                <th>Make</th>
                                                <th>Model</th>
                                                <th>Year</th>
                                                <th>VIN</th>
                                                <th>Mileage</th>
                                                <th>Reported Problem</th>
                                            </tr>
                                        </thead>
                                        <tbody id="customer-vehicles-list">
                                            <tr><td colspan="7" class="text-center text-muted">Loading vehicles...</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p id="no-vehicles-message" class="text-muted text-center" style="display: none;">No vehicles registered for this customer.</p>
                            </div>

                            <!-- Job History Tab (Placeholder) -->
                            <div class="tab-pane fade" id="customer-jobs" role="tabpanel" aria-labelledby="customer-jobs-tab">
                                <h6 class="mb-3 text-secondary">Job History</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Job No.</th>
                                                <th>Vehicle Reg No.</th>
                                                <th>Date In</th>
                                                <th>Status</th>
                                                <th>Problem</th>
                                            </tr>
                                        </thead>
                                        <tbody id="customer-jobs-list">
                                            <tr><td colspan="5" class="text-center text-muted">No job history available for this customer.</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Invoices Tab (Placeholder) -->
                            <div class="tab-pane fade" id="customer-invoices" role="tabpanel" aria-labelledby="customer-invoices-tab">
                                <h6 class="mb-3 text-secondary">Invoices & Payments</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Invoice No.</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="customer-invoices-list">
                                            <tr><td colspan="4" class="text-center text-muted">No invoices available for this customer.</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Communication Log Tab (Placeholder) -->
                            <div class="tab-pane fade" id="customer-communication" role="tabpanel" aria-labelledby="customer-communication-tab">
                                <h6 class="mb-3 text-secondary">Communication Log</h6>
                                <div class="list-group">
                                    <div class="list-group-item d-flex align-items-start gap-3">
                                        <i class="bi bi-chat-dots-fill text-primary mt-1"></i>
                                        <div>
                                            <small class="text-muted">2025-06-01 10:30 AM (Receptionist)</small>
                                            <p class="mb-1">Call received regarding job status of ABC 123. Informed customer of parts delay.</p>
                                        </div>
                                    </div>
                                    <div class="list-group-item d-flex align-items-start gap-3">
                                        <i class="bi bi-envelope-fill text-success mt-1"></i>
                                        <div>
                                            <small class="text-muted">2025-05-28 09:00 AM (System)</small>
                                            <p class="mb-1">Automated email sent: Job Card #XYZ-456 created.</p>
                                        </div>
                                    </div>
                                    <div id="customer-communication-list">
                                        <div class="text-center text-muted py-3">No further communication entries.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Close
                </button>
                <button type="button" class="btn btn-primary" onclick="openModal('<?= base_url('admin/customers/edit/') ?>' + document.getElementById('overview_id').innerText, 'Edit Customer Details')">
                     <i class="bi bi-pencil-square me-1"></i> Edit Customer
                </button>
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
                Are you sure you want to delete the selected customer(s)? This action cannot be undone.
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>


<!-- jQuery (ensure this is loaded before DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- DataTables Bootstrap 5 Integration (if using Bootstrap 5 layout for DataTables) -->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.all.min.js"></script>


<script>
    // Make openModal function globally accessible if it's used in onclick attributes
    function openModal(url, title = 'Form') {
        const modalElement = document.getElementById('actionModal');
        const modal = new bootstrap.Modal(modalElement);
        const modalTitle = modalElement.querySelector('.modal-title');
        const modalContent = document.getElementById('modalContent');

        modalContent.innerHTML = `
            <div class="d-flex justify-content-center align-items-center" style="min-height: 100px;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        modalTitle.textContent = title;

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
            modalContent.innerHTML = data;
        })
        .catch(error => {
            modalTitle.textContent = 'Error';
            modalContent.innerHTML = `<div class="alert alert-danger" role="alert">Error loading content: ${error.message}. Please try again.</div>`;
            console.error('Error loading modal content:', error);
        });
    }
    window.openModal = openModal; // Expose to global scope for onclick attributes


    $(document).ready(function() {
        const selectAllCheckbox = document.getElementById('select_all_customers'); // Updated ID
        const deleteSelectedBtn = document.getElementById('deleteSelectedBtn'); // You might want to add this button if you have bulk delete for customers
        const bulkActionForm = document.getElementById('bulkActionForm'); // If you have bulk delete form

        // --- DataTables Initialization ---
        const customerTable = $('#customerTable').DataTable({ // Corrected ID
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= base_url('customers/load') ?>",
                type: "POST"
            },
            columns: [
                {
                    data: 'id',
                    orderable: false,
                    render: function(data, type, row) {
                        return `<input type="checkbox" name="customers[]" value="${data}">`;
                    }
                },
                { data: "name" },
                { data: "phone" },
                { data: "email" },
                {
                    data: "vehicle_count", // Assuming backend provides this
                    render: function(data, type, row) {
                        return data > 0 ? `${data} vehicles` : '0 vehicles';
                    }
                },
                {
                    data: null, // For action buttons
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <div class="d-flex justify-content-around">
                                <button class="icon-btn text-primary view-customer" title="View Details" data-id="${row.id}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="icon-btn text-info edit-customer" title="Edit Customer" data-id="${row.id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="icon-btn text-danger delete-customer" title="Delete Customer" data-id="${row.id}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            dom: '<"top d-flex justify-content-between flex-wrap"<"mb-2"l><"mb-2"f>>rt<"bottom d-flex justify-content-between flex-wrap"<"mb-2"i><"mb-2"p>><"clear">',
            language: {
                search: "",
                searchPlaceholder: "Search customers...",
            }
        });

        // --- Checkbox Select All (Optional, if you implement bulk delete) ---
        if (selectAllCheckbox) { // Check if element exists before adding listener
            selectAllCheckbox.addEventListener('change', function() {
                const checkboxes = customerTable.rows({ page: 'current' }).nodes().to$().find('input[type="checkbox"]');
                checkboxes.prop('checked', this.checked);
            });
        }


        // --- Customer Details Modal ---
        const customerDetailsModalElement = document.getElementById('customerDetailsModal');
        const customerDetailsModal = new bootstrap.Modal(customerDetailsModalElement);

        $('#customerTable tbody').on('click', '.view-customer', async function() {
            const customerId = $(this).data('id');

            // Clear previous data and show loading spinners/placeholders
            $('#customer-profile-picture').attr('src', 'https://placehold.co/100x100/cccccc/333333?text=CS');
            $('#customer-fullname-modal').text('Loading...');
            $('#customer-phone-modal').text('');
            $('#customer-email-modal').text('');
            $('#customer-address-modal').text('');
            $('#customer-created-at').text('');

            // Overview tab
            $('#overview_fullname').text('Loading...');
            $('#overview_phone').text('');
            $('#overview_email').text('');
            $('#overview_address').text('');
            $('#overview_id').text('');

            // Vehicles tab
            $('#customer-vehicles-list').html('<tr><td colspan="7" class="text-center text-muted">Loading vehicles...</td></tr>');
            $('#no-vehicles-message').hide(); // Hide initially

            // Other tabs - placeholders
            $('#customer-jobs-list').html('<tr><td colspan="5" class="text-center text-muted">Loading job history...</td></tr>');
            $('#customer-invoices-list').html('<tr><td colspan="4" class="text-center text-muted">Loading invoices...</td></tr>');
            $('#customer-communication-list').html('<div class="text-center text-muted py-3">Loading communication log...</div>');


            customerDetailsModal.show();

            try {
                const response = await fetch(`<?= base_url('admin/customers/details/') ?>${customerId}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                if (!response.ok) {
                    throw new Error(`Failed to fetch customer details (Status: ${response.status})`);
                }

                const data = await response.json();

                // Populate Customer Summary (Left Column)
                // You might generate initials for the photo or use a default if no photo field exists
                const initials = data.name ? data.name.split(' ').map(n => n[0]).join('').toUpperCase() : 'CS';
                $('#customer-profile-picture').attr('src', `https://placehold.co/100x100/cccccc/333333?text=${initials}`);
                $('#customer-fullname-modal').text(data.name || 'N/A');
                $('#customer-phone-modal').text(data.phone || 'N/A');
                $('#customer-email-modal').text(data.email || 'N/A');
                $('#customer-address-modal').text(data.address || 'N/A');
                $('#customer-created-at').text(data.created_at ? new Date(data.created_at).toLocaleDateString() : 'N/A');

                // Populate Overview Tab
                $('#overview_fullname').text(data.name || 'N/A');
                $('#overview_phone').text(data.phone || 'N/A');
                $('#overview_email').text(data.email || 'N/A');
                $('#overview_address').text(data.address || 'N/A');
                $('#overview_id').text(data.id || 'N/A');


                // Populate Vehicles Owned Tab
                const vehiclesList = $('#customer-vehicles-list');
                vehiclesList.empty(); // Clear loading message
                if (data.vehicles && data.vehicles.length > 0) {
                    data.vehicles.forEach(vehicle => {
                        vehiclesList.append(`
                            <tr>
                                <td>${vehicle.registration_number || 'N/A'}</td>
                                <td>${vehicle.make || 'N/A'}</td>
                                <td>${vehicle.model || 'N/A'}</td>
                                <td>${vehicle.year_of_manufacture || 'N/A'}</td>
                                <td>${vehicle.vin || 'N/A'}</td>
                                <td>${vehicle.mileage || '0'}</td>
                                <td>${vehicle.reported_problem || 'N/A'}</td>
                            </tr>
                        `);
                    });
                } else {
                    vehiclesList.append('<tr><td colspan="7" class="text-center text-muted">No vehicles registered for this customer.</td></tr>');
                }

                // Populate Job History Tab (MOCK DATA for now)
                const jobsList = $('#customer-jobs-list');
                jobsList.empty();
                if (data.jobs && data.jobs.length > 0) {
                    data.jobs.forEach(job => {
                        jobsList.append(`
                            <tr>
                                <td>${job.job_no || 'N/A'}</td>
                                <td>${job.vehicle_reg_no || 'N/A'}</td>
                                <td>${job.date_in || 'N/A'}</td>
                                <td>${job.status || 'N/A'}</td>
                                <td>${job.problem || 'N/A'}</td>
                            </tr>
                        `);
                    });
                } else {
                    jobsList.append('<tr><td colspan="5" class="text-center text-muted">No job history available for this customer.</td></tr>');
                }

                // Populate Invoices Tab (MOCK DATA for now)
                const invoicesList = $('#customer-invoices-list');
                invoicesList.empty();
                if (data.invoices && data.invoices.length > 0) {
                    data.invoices.forEach(invoice => {
                        invoicesList.append(`
                            <tr>
                                <td>${invoice.invoice_no || 'N/A'}</td>
                                <td>${invoice.date || 'N/A'}</td>
                                <td>Ksh ${parseFloat(invoice.amount || 0).toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                                <td>${invoice.status || 'N/A'}</td>
                            </tr>
                        `);
                    });
                } else {
                    invoicesList.append('<tr><td colspan="4" class="text-center text-muted">No invoices available for this customer.</td></tr>');
                }

                 // Populate Communication Log Tab (MOCK DATA for now)
                const communicationList = $('#customer-communication-list');
                communicationList.empty();
                if (data.communication_log && data.communication_log.length > 0) {
                    data.communication_log.forEach(log => {
                        communicationList.append(`
                             <div class="list-group-item d-flex align-items-start gap-3">
                                <i class="bi ${log.type === 'call' ? 'bi-chat-dots-fill text-primary' : 'bi-envelope-fill text-success'} mt-1"></i>
                                <div>
                                    <small class="text-muted">${log.date} (${log.agent})</small>
                                    <p class="mb-1">${log.message}</p>
                                </div>
                            </div>
                        `);
                    });
                } else {
                    communicationList.append('<div class="text-center text-muted py-3">No communication entries.</div>');
                }


            } catch (error) {
                const modalBody = customerDetailsModalElement.querySelector('.modal-body');
                modalBody.innerHTML = `<div class="alert alert-danger" role="alert">
                                            <i class="bi bi-exclamation-circle me-2"></i> Failed to load customer details: ${error.message}
                                        </div>`;
                console.error('Error fetching customer details:', error);
            }
        });

        // --- Edit Customer Logic ---
        $('#customerTable tbody').on('click', '.edit-customer', function() {
            const customerId = $(this).data('id');
            openModal(`<?= base_url('admin/customers/edit/') ?>${customerId}`, 'Edit Customer Details');
        });

        // --- Delete Customer Logic ---
        let customerIdToDelete = null; // Store ID for confirmation
        const confirmDeleteModalElement = document.getElementById('confirmDeleteModal');
        const confirmDeleteModal = new bootstrap.Modal(confirmDeleteModalElement);
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        $('#customerTable tbody').on('click', '.delete-customer', function() {
            customerIdToDelete = $(this).data('id');
            confirmDeleteModal.show();
        });

        confirmDeleteBtn.addEventListener('click', async function() {
            confirmDeleteModal.hide(); // Hide the confirmation modal
            if (customerIdToDelete) {
                try {
                    // Using POST for deletion as good practice, sending ID in body
                    const response = await fetch(`<?= base_url('admin/customers/bulk_action') ?>`, { // Re-using bulk_action for single delete for simplicity, or create a specific delete endpoint
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json' // Assuming your bulk_action can handle JSON payload
                        },
                        body: JSON.stringify({ customers: [customerIdToDelete] }) // Send as an array of IDs
                    });

                    const responseData = await response.json(); // Assuming JSON response

                    if (response.ok && responseData.status === 'success') {
                        Swal.fire('Deleted!', responseData.message, 'success');
                        customerTable.ajax.reload(); // Reload DataTables
                    } else {
                        Swal.fire('Error!', responseData.message || 'Failed to delete customer.', 'error');
                    }
                } catch (error) {
                    console.error('Error during deletion:', error);
                    Swal.fire('Error!', 'An unexpected error occurred during deletion.', 'error');
                } finally {
                    customerIdToDelete = null; // Clear the ID
                }
            }
        });

        // --- Placeholder for Bulk Delete button if you add it ---
        if (deleteSelectedBtn) {
            deleteSelectedBtn.addEventListener('click', function() {
                const checkedCustomerIds = [];
                customerTable.rows().nodes().to$().find('input[name="customers[]"]:checked').each(function() {
                    checkedCustomerIds.push($(this).val());
                });

                if (checkedCustomerIds.length === 0) {
                    Swal.fire('No Selection', 'Please select at least one customer to delete.', 'info');
                    return;
                }

                Swal.fire({
                    title: 'Confirm Deletion',
                    text: `Are you sure you want to delete ${checkedCustomerIds.length} selected customer(s)? This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form with selected IDs for bulk action
                        // You'll need to create hidden inputs for these IDs or use AJAX to send
                        // For simplicity, directly calling the AJAX here, assuming backend handles array
                        performBulkDelete(checkedCustomerIds);
                    }
                });
            });
        }

        async function performBulkDelete(customerIds) {
            try {
                const response = await fetch(`<?= base_url('admin/customers/bulk_action') ?>`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ customers: customerIds })
                });

                const responseData = await response.json();

                if (response.ok && responseData.status === 'success') {
                    Swal.fire('Deleted!', responseData.message, 'success');
                    customerTable.ajax.reload();
                    if (selectAllCheckbox) selectAllCheckbox.checked = false; // Uncheck select all
                } else {
                    Swal.fire('Error!', responseData.message || 'Failed to perform bulk deletion.', 'error');
                }
            } catch (error) {
                console.error('Error during bulk deletion:', error);
                Swal.fire('Error!', 'An unexpected error occurred during bulk deletion.', 'error');
            }
        }

    });
</script>

<?= $this->endSection() ?>
