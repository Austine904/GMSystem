<!-- Customer Details Modal -->
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
                                            <tr>
                                                <td colspan="7" class="text-center text-muted">Loading vehicles...</td>
                                            </tr>
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
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">No job history available for this customer.</td>
                                            </tr>
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
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No invoices available for this customer.</td>
                                            </tr>
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