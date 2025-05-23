<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

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
        /* Ensure consistent top margin */
        margin-top: 3rem !important;
    }

    h3 {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 2rem !important;
        /* Consistent spacing */
    }

    /* General Button Styling */
    .btn {
        border-radius: 8px;
        /* Consistent rounded corners */
        font-weight: 500;
        transition: all 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        /* Subtle lift on hover */
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

    .btn-danger {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
        /* Darker red on hover */
        border-color: #c82333;
    }

    .btn-primary.btn-sm {
        /* For view user button */
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        padding: 0.25rem 0.75rem;
        /* Smaller padding for sm button */
    }

    .btn-primary.btn-sm:hover {
        background-color: var(--primary-hover-color);
        border-color: var(--primary-hover-color);
    }


    /* Form Controls (Search, Select) */
    .form-control,
    .form-select {
        border-radius: 8px;
        /* Consistent rounded corners */
        border-color: #ced4da;
        padding: 0.75rem 1rem;
        /* More generous padding */
        box-shadow: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus,
    .form-select:focus {
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
        /* Rounded corners for the table container */
        overflow: hidden;
        /* Ensures corners are respected */
        box-shadow: 0 5px 15px var(--shadow-light);
        /* Subtle shadow for table */
        border: none;
        /* Remove default table border */
        width: 100% !important;
        /* Ensure DataTables uses full width */
    }

    .table-striped>tbody>tr:nth-of-type(odd)>* {
        background-color: var(--bg-light);
        /* Lighter stripe */
    }

    .table-bordered {
        border: 1px solid rgba(0, 0, 0, 0.08);
        /* Lighter border for overall table */
    }

    .table-bordered> :not(caption)>*>* {
        border-width: 0 1px 1px 0;
        /* Only right and bottom borders for cells */
        border-color: rgba(0, 0, 0, 0.08);
    }

    .table-bordered> :not(caption)>*> :first-child {
        border-left-width: 0;
        /* Remove left border for first column */
    }

    .table-bordered> :not(caption)> :first-child>* {
        border-top-width: 0;
        /* Remove top border for first row */
    }

    .table thead.table-light th {
        background-color: var(--primary-color);
        /* Primary color for header */
        color: white;
        font-weight: 600;
        border-color: var(--primary-color);
        /* Match border color */
        padding: 1rem 1.25rem;
        /* More padding */
    }

    .table tbody tr td {
        padding: 1rem 1.25rem;
        /* Consistent padding */
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


    /* === MODAL STYLING (Modernized) === */
    .modal-backdrop.fade {
        opacity: 0.7;
        /* Darker overlay */
    }

    .modal.fade .modal-dialog {
        transform: translate(0, -50px);
        /* Start slightly above center */
        opacity: 0;
        transition: transform 0.3s ease-out, opacity 0.3s ease-out;
    }

    .modal.show .modal-dialog {
        transform: translate(0, 0);
        /* Slide to center */
        opacity: 1;
    }

    .modal-content {
        border-radius: 15px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
        /* Softer, larger shadow */
        border: none;
        overflow: hidden;
        /* Ensure content respects border-radius */
    }

    .modal-header {
        border-bottom: none;
        padding: 1.5rem;
        background-color: var(--card-bg);
        /* Default light background for header */
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .modal-title {
        font-weight: 700;
        /* Bolder title */
        color: var(--primary-color);
        font-size: 1.6rem;
        /* Slightly larger title */
    }

    .modal-body {
        padding: 1.5rem;
        color: var(--text-dark);
    }

    .modal-footer {
        border-top: none;
        /* Remove default footer border */
        padding: 1rem 1.5rem;
        background-color: var(--card-bg);
    }

    .modal-footer .btn {
        padding: 0.6rem 1.2rem;
        /* Adjust button padding in footer */
        font-size: 0.95rem;
    }


    /* User Details Modal Specifics (with gradient header) */
    #userDetailsModal .modal-dialog {
        max-width: 900px;
        /* Adjust as needed for content */
    }

    #userDetailsModal .modal-header {
        background: linear-gradient(90deg, var(--primary-color), var(--primary-hover-color)) !important;
        /* Gradient header */
        color: white !important;
        border-top-left-radius: 15px;
        /* Match content border radius */
        border-top-right-radius: 15px;
    }

    #userDetailsModal .modal-header .modal-title {
        color: white !important;
    }

    #userDetailsModal .modal-header .btn-close {
        filter: invert(1);
        /* Make close button white */
    }

    #userDetailsModal .profile-card {
        text-align: center;
        padding: 1.5rem;
        border-radius: 10px;
        background-color: var(--bg-light);
        box-shadow: var(--shadow-light);
    }

    #userDetailsModal .profile-picture {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--primary-color);
        margin-bottom: 1rem;
    }

    #userDetailsModal .info-item {
        margin-bottom: 0.75rem;
        text-align: left;
    }

    #userDetailsModal .info-label {
        font-weight: 600;
        color: var(--text-dark);
        display: block;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }

    #userDetailsModal .info-value {
        color: #555;
        font-size: 1rem;
    }

    /* Tab Styling within User Details Modal */
    #userDetailsModal .nav-tabs {
        border-bottom: none;
        /* Remove default tab border */
        margin-bottom: 1.5rem;
    }

    #userDetailsModal .nav-tabs .nav-item .nav-link {
        border: none;
        /* Remove individual tab borders */
        border-radius: 8px 8px 0 0;
        /* Rounded top corners */
        background-color: transparent;
        color: var(--text-dark);
        font-weight: 500;
        padding: 0.75rem 1.25rem;
        transition: all 0.2s ease;
        position: relative;
        /* For active indicator */
    }

    #userDetailsModal .nav-tabs .nav-item .nav-link:hover {
        color: var(--primary-color);
        background-color: rgba(0, 123, 255, 0.05);
    }

    #userDetailsModal .nav-tabs .nav-item .nav-link.active {
        color: var(--primary-color);
        background-color: var(--card-bg);
        /* Active tab background */
        font-weight: 600;
    }

    #userDetailsModal .nav-tabs .nav-item .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 3px;
        /* Active indicator thickness */
        background-color: var(--primary-color);
        border-radius: 2px 2px 0 0;
    }

    #userDetailsModal .tab-content {
        background-color: var(--card-bg);
        border-radius: 0 0 15px 15px;
        /* Match modal content border */
        padding: 1.5rem;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        /* Subtle shadow for tab content */
        border: 1px solid rgba(0, 0, 0, 0.08);
        /* Light border */
        border-top: none;
        /* No top border, as tabs are above */
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
</style>

<div class="container mt-5">
    <h3>User Management</h3>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <button onclick="openModal('<?= base_url('admin/users/add') ?>', 'Add New User')" class="btn btn-outline-primary d-flex align-items-center gap-2">
            <i class="bi bi-person-plus"></i> Add User
        </button>

        <div class="d-flex gap-2">
            <select class="form-select" id="role-filter">
                <option value="">All Roles</option>
                <option value="admin">Admin</option>
                <option value="mechanic">Mechanic</option>
                <option value="receptionist">Receptionist</option>
            </select>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('admin/users/bulk_action') ?>" id="bulkActionForm">
        <button type="button" class="btn btn-danger mb-3" id="deleteSelectedBtn">
            <i class="bi bi-trash me-1"></i> Delete Selected
        </button>

        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="userTable">
                <thead class="table-light">
                    <tr>
                        <th><input type="checkbox" id="select_all"></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div id="pagination-links-container"></div>
    </form>
</div>

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

<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailsModalLabel">
                    <i class="bi bi-person-circle me-2"></i> User Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-card">
                            <img id="profile_picture" src="https://placehold.co/150x150/cccccc/333333?text=No+Photo" class="profile-picture" alt="User Photo">
                            <h5 class="card-title" id="user-fullname"></h5>
                            <div class="info-item"><span class="info-label">Company ID:</span> <span class="info-value" id="company_id"></span></div>
                            <div class="info-item"><span class="info-label">Role:</span> <span class="info-value" id="user-role"></span></div>
                            <div class="info-item"><span class="info-label">Phone:</span> <span class="info-value" id="user-phone"></span></div>
                            <div class="info-item"><span class="info-label">Email:</span> <span class="info-value" id="user-email"></span></div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <ul class="nav nav-tabs mb-3" id="userDetailsTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab" aria-controls="personal" aria-selected="true">Personal Info</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="employment-tab" data-bs-toggle="tab" data-bs-target="#employment" type="button" role="tab" aria-controls="employment" aria-selected="false">Employment</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="kin-tab" data-bs-toggle="tab" data-bs-target="#kin" type="button" role="tab" aria-controls="kin" aria-selected="false">Next of Kin</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="userDetailsTabContent">
                            <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                                <div class="info-item"><span class="info-label">Date of Birth:</span> <span class="info-value" id="dob"></span></div>
                                <div class="info-item"><span class="info-label">National ID:</span> <span class="info-value" id="national_id"></span></div>
                                <div class="info-item"><span class="info-label">Address:</span> <span class="info-value" id="user-address"></span></div>
                            </div>
                            <div class="tab-pane fade" id="employment" role="tabpanel" aria-labelledby="employment-tab">
                                <div class="info-item"><span class="info-label">Employment Date:</span> <span class="info-value" id="date_of_employment"></span></div>
                                <div class="info-item"><span class="info-label">Department:</span> <span class="info-value" id="department">N/A</span></div>
                            </div>
                            <div class="tab-pane fade" id="kin" role="tabpanel" aria-labelledby="kin-tab">
                                <div class="info-item"><span class="info-label">Next of Kin Name:</span> <span class="info-value" id="kin_first_name"></span> <span class="info-value" id="kin_last_name"></span></div>
                                <div class="info-item"><span class="info-label">Next of Kin Phone:</span> <span class="info-value" id="kin_phone_number"></span></div>
                                <div class="info-item"><span class="info-label">Relationship:</span> <span class="info-value" id="kin_relationship">N/A</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Close
                </button>
                <button type="button" onclick="openModal('<?= base_url('admin/users/edit/') ?>' + document.getElementById('company_id').innerText, 'Edit User Details')" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit User
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade custom-confirm-modal" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel"><i class="bi bi-exclamation-triangle me-2"></i> Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                Are you sure you want to delete the selected user(s)? This action cannot be undone.
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select_all');
        const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
        const bulkActionForm = document.getElementById('bulkActionForm');

        // --- DataTables Initialization ---
        // Initialize DataTable with server-side processing
        // IMPORTANT: Your backend endpoint 'admin/users/fetch' must be updated
        // to return JSON data in DataTables format (e.g., { "data": [...], "recordsTotal": N, "recordsFiltered": M })
        // and handle 'draw', 'start', 'length', 'search[value]', 'order' parameters.
        const userTable = $('#userTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('admin/users/fetch') ?>',
                type: 'GET', // Or GET, depending on your backend
                data: function(d) {
                    // Add custom filters to the DataTables request
                    d.role_filter = $('#role-filter').val(); // Send role filter
                    // DataTables automatically sends search[value], order, length, start, draw
                }
            },
            columns: [{
                    "data": 'id',
                    orderable: false,
                    render: function(data, type, row) {
                        return `<input type="checkbox" name="users[]" value="${data}">`;
                    }
                },
                {
                    "data": 'id'
                },
                {
                    "data": 'name',
                },
                {
                    "data": 'phone'
                },
                {
                    "data": 'role',
                    render: function(data, type, row) {
                        return ucfirst(data);
                    }
                },
                {
                    render: function(data, type, row) {
                        return `
        <button type="button" class="btn btn-primary btn-sm view-user" data-id="${row.id}">
            <i class="bi bi-eye"></i> View
        </button>
    `;
                    }

                }
            ],
            // Customizing DataTables layout elements
            dom: '<"top d-flex justify-content-between flex-wrap"<"mb-2"l><"mb-2"f>>rt<"bottom d-flex justify-content-between flex-wrap"<"mb-2"i><"mb-2"p>><"clear">',
            language: {
                search: "", // Remove default "Search:" label
                searchPlaceholder: "Search User...", // Add placeholder to search input
            },
            // Re-draw table when role filter changes
            initComplete: function() {
                // Move the custom role filter into the DataTables filter area
                $('#userTable_filter').prepend($('#role-filter').detach());
                $('#role-filter').addClass('ms-2'); // Add some margin

                // Apply filter on change
                $('#role-filter').on('change', function() {
                    userTable.ajax.reload(); // Reload DataTables data
                });
            }
        });

        // --- Checkbox Select All for DataTables ---
        selectAllCheckbox.addEventListener('change', function() {
            // Get all checkboxes in the current page of DataTables
            const checkboxes = userTable.rows({
                page: 'current'
            }).nodes().to$().find('input[type="checkbox"]');
            checkboxes.prop('checked', this.checked);
        });

        // --- Custom Confirmation Modal for Delete ---
        const confirmDeleteModalElement = document.getElementById('confirmDeleteModal');
        const confirmDeleteModal = new bootstrap.Modal(confirmDeleteModalElement);
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        deleteSelectedBtn.addEventListener('click', function() {
            // Get checked checkboxes from all pages (if serverSide is false) or current page (if serverSide is true)
            // For serverSide, it's safer to get IDs of selected rows from a tracking array if you implement one.
            // For simplicity here, we'll get from current page:
            const checkedUsers = userTable.rows().nodes().to$().find('input[name="users[]"]:checked');

            if (checkedUsers.length === 0) {
                // Use a custom message box instead of alert
                alert("Please select at least one user to delete."); // Temporary alert for demonstration

                // showInfoModal("No Selection", "Please select at least one user to delete.");
                return;
            }
            confirmDeleteModal.show();
        });

        confirmDeleteBtn.addEventListener('click', function() {
            confirmDeleteModal.hide();
            bulkActionForm.submit(); // Submit the form if confirmed
        });

        // --- Unified openModal Function for Add/Edit ---
        const actionModalElement = document.getElementById('actionModal');
        const actionModal = new bootstrap.Modal(actionModalElement);
        const actionModalTitle = document.getElementById('actionModalLabel');
        const modalContentDiv = document.getElementById('modalContent');

        window.openModal = function(url, title = 'Form') { // Added title parameter
            actionModalTitle.textContent = title;
            modalContentDiv.innerHTML = ` <
                                div class = "spinner-border text-primary"
                                role = "status" >
                                <
                                span class = "visually-hidden" > Loading... < /span> <
                                /div>
                                `; // Show loading spinner
            actionModal.show();

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
                    modalContentDiv.innerHTML = data;
                })
                .catch(error => {
                    modalContentDiv.innerHTML = ` < div class = "alert alert-danger"
                                role = "alert" > Error loading content: $ {
                                    error.message
                                }.Please
                                try again. < /div>`;
                    console.error('Error loading modal content:', error);
                });
        }

        // --- View User Details Modal ---
        const userDetailsModalElement = document.getElementById('userDetailsModal');
        const userDetailsModal = new bootstrap.Modal(userDetailsModalElement);

        // Attach event listener for 'View' buttons using delegation
        // This is crucial because DataTables dynamically adds/removes rows.
        $('#userTable tbody').on('click', '.view-user', async function() {
            const userId = $(this).data('id');

            if (!userId) {
                console.error('User ID not found for this button.');
                return;
            }
            // Clear previous data and show loading spinner
            document.getElementById('user-fullname').innerText = 'Loading...';
            document.getElementById('company_id').innerText = '';
            document.getElementById('profile_picture').src = 'https://placehold.co/150x150/cccccc/333333?text=Loading...';
            // Clear other fields as well

            userDetailsModal.show(); // Show modal immediately with loading state

            try {
                const response = await fetch(`<?= base_url('admin/users/fetch/') ?>${userId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error(`Failed to fetch user details (Status: ${response.status})`);
                }

                const data = await response.json();

                //echo all data
                console.log(data);

                // Populate Basic Details
                document.getElementById('profile_picture').src = data.profile_picture ? `<?= base_url() ?>/${data.profile_picture}` : 'https://placehold.co/150x150/cccccc/333333?text=No+Photo';
                document.getElementById('user-fullname').innerText = `${data.first_name || ''} ${data.last_name || ''}`;
                document.getElementById('company_id').innerText = data.company_id || 'N/A';
                document.getElementById('user-role').innerText = data.role ? ucfirst(data.role) : 'N/A';
                document.getElementById('user-phone').innerText = data.phone_number || 'N/A';
                document.getElementById('user-email').innerText = data.email || 'N/A';

                // Populate Personal Info Tab
                document.getElementById('dob').innerText = data.dob || 'N/A';
                document.getElementById('national_id').innerText = data.national_id || 'N/A';
                document.getElementById('user-address').innerText = data.address || 'N/A';

                // Populate Employment Tab
                document.getElementById('date_of_employment').innerText = data.date_of_employment || 'N/A';
                document.getElementById('department').innerText = data.department || 'N/A'; // Assuming 'department' field

                // Populate Next of Kin Tab

                const kin = data.next_of_kin || {}; // Assuming 'kin' is an object in the response

                document.getElementById('kin_first_name').innerText = `${kin.kin_first_name || ''} ${kin.kin_last_name || ''}`.trim() || 'N/A';
                document.getElementById('kin_last_name').innerText = kin.kin_last_name || '';
                document.getElementById('kin_phone_number').innerText = kin.kin_phone_number || 'N/A';
                document.getElementById('kin_relationship').innerText = kin.relationship || 'N/A';

            } catch (error) {
                // Display error message directly in the modal body or a dedicated alert area
                const modalBody = userDetailsModalElement.querySelector('.modal-body');
                modalBody.innerHTML = `<div class="alert alert-danger" role="alert">
                                            <i class="bi bi-exclamation-circle me-2"></i> Failed to load user details: ${error.message}
                                        </div>`;
                console.error('Error fetching user details:', error);
            }
        });

        // --- Helper for ucfirst in JS (if needed for roles) ---
        function ucfirst(str) {
            if (typeof str !== 'string' || str.length === 0) {
                return '';
            }
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
    });
</script>
<?= $this->endSection(); ?>