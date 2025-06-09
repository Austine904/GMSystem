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
