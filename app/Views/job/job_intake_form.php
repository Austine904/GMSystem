<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Add any specific styles for this form if needed, e.g., for input focus, button colors */
    .form-group label {
        font-weight: 500;
        color: #343a40; /* text-dark */
    }
    .form-control:focus, .form-select:focus {
        border-color: #007bff; /* primary-color */
        box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
    }
    .card {
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border: none;
    }
    .card-header {
        background-color: #f8f9fa; /* bg-light */
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-weight: 600;
        color: #343a40;
    }
    .search-results-dropdown {
        position: absolute;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        background: white;
        border: 1px solid #ced4da;
        border-top: none;
        z-index: 1000;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    }
    .search-results-dropdown div {
        padding: 0.75rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid #f0f2f5;
    }
    .search-results-dropdown div:last-child {
        border-bottom: none;
    }
    .search-results-dropdown div:hover {
        background-color: #e9ecef;
    }
    .search-results-dropdown .result-title {
        font-weight: 600;
        color: #007bff;
    }
    .search-results-dropdown .result-subtitle {
        font-size: 0.85rem;
        color: #6c757d;
    }
    .photo-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    .photo-preview-container img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    .error-message {
        color: #dc3545; /* danger-color */
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<div class="container mt-5">
    <h3 class="mb-4">Vehicle Reception & Initial Intake</h3>

    <div class="card p-4">
        <div class="card-header mb-4">
            New Job Card
        </div>
        <div class="card-body">
            <form id="jobIntakeForm" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="search_input" class="form-label">Search Customer/Vehicle</label>
                    <input type="text" class="form-control" id="search_input" placeholder="License Plate, VIN, or Phone Number">
                    <div id="search_results" class="search-results-dropdown hidden"></div>
                </div>

                <hr class="my-4">

                <div id="customer_section">
                    <h5 class="mb-3 text-primary">Customer Details <span id="customer_status" class="badge bg-secondary ms-2">New</span></h5>
                    <input type="hidden" id="customer_id" name="customer_id" value="new">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="new_customer_first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="new_customer_first_name" name="new_customer_first_name" required>
                            <div class="error-message" id="error_new_customer_first_name"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="new_customer_last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="new_customer_last_name" name="new_customer_last_name" required>
                            <div class="error-message" id="error_new_customer_last_name"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="new_customer_phone_number" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="new_customer_phone_number" name="new_customer_phone_number" required>
                            <div class="error-message" id="error_new_customer_phone_number"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="new_customer_email" class="form-label">Email Address (Optional)</label>
                            <input type="email" class="form-control" id="new_customer_email" name="new_customer_email">
                            <div class="error-message" id="error_new_customer_email"></div>
                        </div>
                        <div class="col-12">
                            <label for="new_customer_address" class="form-label">Address (Optional)</label>
                            <textarea class="form-control" id="new_customer_address" name="new_customer_address" rows="2"></textarea>
                            <div class="error-message" id="error_new_customer_address"></div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div id="vehicle_section">
                    <h5 class="mb-3 text-primary">Vehicle Details <span id="vehicle_status" class="badge bg-secondary ms-2">New</span></h5>
                    <input type="hidden" id="vehicle_id" name="vehicle_id" value="new">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="new_vehicle_license_plate" class="form-label">License Plate</label>
                            <input type="text" class="form-control" id="new_vehicle_license_plate" name="new_vehicle_license_plate" required>
                            <div class="error-message" id="error_new_vehicle_license_plate"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="new_vehicle_vin" class="form-label">VIN (Vehicle Identification Number)</label>
                            <input type="text" class="form-control" id="new_vehicle_vin" name="new_vehicle_vin" maxlength="17" required>
                            <div class="error-message" id="error_new_vehicle_vin"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="new_vehicle_make" class="form-label">Make</label>
                            <select class="form-select" id="new_vehicle_make" name="new_vehicle_make" required>
                                <option value="">Select Make</option>
                                <option value="Toyota">Toyota</option>
                                <option value="Nissan">Nissan</option>
                                <option value="Honda">Honda</option>
                                <option value="Mazda">Mazda</option>
                                <option value="Subaru">Subaru</option>
                                <option value="Mercedes-Benz">Mercedes-Benz</option>
                                <option value="BMW">BMW</option>
                                <option value="Audi">Audi</option>
                                <option value="Ford">Ford</option>
                                <option value="Volkswagen">Volkswagen</option>
                                </select>
                            <div class="error-message" id="error_new_vehicle_make"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="new_vehicle_model" class="form-label">Model</label>
                            <input type="text" class="form-control" id="new_vehicle_model" name="new_vehicle_model" required>
                            <div class="error-message" id="error_new_vehicle_model"></div>
                        </div>
                        <div class="col-md-4">
                            <label for="new_vehicle_year" class="form-label">Year of Manufacture</label>
                            <input type="number" class="form-control" id="new_vehicle_year" name="new_vehicle_year" min="1900" max="<?= date('Y') + 1 ?>" required>
                            <div class="error-message" id="error_new_vehicle_year"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="new_vehicle_color" class="form-label">Color (Optional)</label>
                            <input type="text" class="form-control" id="new_vehicle_color" name="new_vehicle_color">
                            <div class="error-message" id="error_new_vehicle_color"></div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3 text-primary">Job Details</h5>
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <label for="reported_problem" class="form-label">Customer Reported Problem</label>
                        <textarea class="form-control" id="reported_problem" name="reported_problem" rows="3" required></textarea>
                        <div class="error-message" id="error_reported_problem"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="mileage_in" class="form-label">Mileage In</label>
                        <input type="number" class="form-control" id="mileage_in" name="mileage_in" required min="0">
                        <div class="error-message" id="error_mileage_in"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="fuel_level" class="form-label">Fuel Level</label>
                        <select class="form-select" id="fuel_level" name="fuel_level" required>
                            <option value="">Select Fuel Level</option>
                            <option value="Empty">Empty</option>
                            <option value="1/4">1/4</option>
                            <option value="1/2">1/2</option>
                            <option value="3/4">3/4</option>
                            <option value="Full">Full</option>
                        </select>
                        <div class="error-message" id="error_fuel_level"></div>
                    </div>
                    <div class="col-12">
                        <label for="initial_damage_notes" class="form-label">Initial Visible Damage Notes (Optional)</label>
                        <textarea class="form-control" id="initial_damage_notes" name="initial_damage_notes" rows="2"></textarea>
                        <div class="error-message" id="error_initial_damage_notes"></div>
                    </div>
                    <div class="col-12">
                        <label for="job_card_photos" class="form-label">Upload Job Card Photos (Optional)</label>
                        <input type="file" class="form-control" id="job_card_photos" name="job_card_photos[]" multiple accept="image/*">
                        <div class="photo-preview-container" id="photo_preview_container"></div>
                        <div class="error-message" id="error_job_card_photos"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="assigned_service_advisor_id" class="form-label">Assigned Service Advisor</label>
                        <select class="form-select" id="assigned_service_advisor_id" name="assigned_service_advisor_id" required>
                            <option value="">Select Advisor</option>
                            <?php foreach ($service_advisors as $advisor): ?>
                                <option value="<?= esc($advisor['id']) ?>"><?= esc($advisor['first_name'] . ' ' . $advisor['last_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="error-message" id="error_assigned_service_advisor_id"></div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary btn-lg d-flex align-items-center gap-2">
                        <i class="bi bi-plus-circle"></i> Create Job Card
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        const searchInput = $('#search_input');
        const searchResultsDiv = $('#search_results');
        const customerIdInput = $('#customer_id');
        const customerStatusBadge = $('#customer_status');
        const vehicleIdInput = $('#vehicle_id');
        const vehicleStatusBadge = $('#vehicle_status');
        const jobIntakeForm = $('#jobIntakeForm');
        const photoInput = $('#job_card_photos');
        const photoPreviewContainer = $('#photo_preview_container');

        // Store original states of customer/vehicle fields for reset
        const originalCustomerFields = $('#customer_section input, #customer_section textarea').not('#customer_id');
        const originalVehicleFields = $('#vehicle_section input, #vehicle_section select').not('#vehicle_id');

        // Function to reset customer/vehicle sections to 'new' state
        function resetCustomerVehicleSections() {
            customerIdInput.val('new');
            customerStatusBadge.text('New').removeClass('bg-success').addClass('bg-secondary');
            originalCustomerFields.val('');
            originalCustomerFields.prop('disabled', false);

            vehicleIdInput.val('new');
            vehicleStatusBadge.text('New').removeClass('bg-success').addClass('bg-secondary');
            originalVehicleFields.val('');
            originalVehicleFields.prop('disabled', false);

            // Clear any previous error messages
            $('.error-message').text('');
        }

        // --- Search Functionality ---
        let searchTimeout;
        searchInput.on('keyup', function() {
            clearTimeout(searchTimeout);
            const query = $(this).val().trim();

            if (query.length < 3) { // Minimum 3 characters for search
                searchResultsDiv.empty().addClass('hidden');
                resetCustomerVehicleSections();
                return;
            }

            searchTimeout = setTimeout(function() {
                $.ajax({
                    url: '<?= base_url('job_intake/search') ?>',
                    method: 'GET',
                    data: { query: query },
                    dataType: 'json',
                    success: function(response) {
                        searchResultsDiv.empty();
                        if (response.customers.length === 0 && response.vehicles.length === 0) {
                            searchResultsDiv.append('<div class="text-muted text-center">No existing matches. Will create new.</div>');
                            resetCustomerVehicleSections(); // Reset if no matches
                        } else {
                            searchResultsDiv.removeClass('hidden');
                            if (response.customers.length > 0) {
                                searchResultsDiv.append('<div class="p-2 bg-light text-primary fw-bold">Customers</div>');
                                $.each(response.customers, function(index, customer) {
                                    searchResultsDiv.append(`
                                        <div class="search-result-item" data-type="customer" data-id="${customer.id}" data-name="${customer.name}" data-phone="${customer.phone}" data-email="${customer.email || ''}" data-address="${customer.address || ''}">
                                            <div class="result-title">${customer.name}</div>
                                            <div class="result-subtitle">Phone: ${customer.phone}</div>
                                        </div>
                                    `);
                                });
                            }
                            if (response.vehicles.length > 0) {
                                searchResultsDiv.append('<div class="p-2 bg-light text-primary fw-bold">Vehicles</div>');
                                $.each(response.vehicles, function(index, vehicle) {
                                    searchResultsDiv.append(`
                                        <div class="search-result-item" data-type="vehicle" data-id="${vehicle.id}" data-owner-id="${vehicle.owner_id}" data-reg-no="${vehicle.registration_number}" data-vin="${vehicle.vin || ''}" data-make="${vehicle.make}" data-model="${vehicle.model}" data-year="${vehicle.year_of_manufacture}" data-color="${vehicle.color || ''}" data-owner-name="${vehicle.owner_name || ''}" data-mileage="${vehicle.mileage || 0}" data-reported-problem="${vehicle.reported_problem || ''}">
                                            <div class="result-title">${vehicle.registration_number} (${vehicle.make} ${vehicle.model})</div>
                                            <div class="result-subtitle">Owner: ${vehicle.owner_name}</div>
                                        </div>
                                    `);
                                });
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        searchResultsDiv.empty().addClass('hidden');
                        console.error("Search error:", xhr.responseText);
                        alert('Search failed. Please try again.');
                    }
                });
            }, 300); // 300ms debounce
        });

        // Handle selection from search results
        searchResultsDiv.on('click', '.search-result-item', function() {
            const itemType = $(this).data('type');
            searchResultsDiv.empty().addClass('hidden');
            searchInput.val(''); // Clear search input after selection

            if (itemType === 'customer') {
                resetCustomerVehicleSections(); // Reset both first
                const customer = $(this).data();
                customerIdInput.val(customer.id);
                customerStatusBadge.text('Existing').removeClass('bg-secondary').addClass('bg-success');
                $('#new_customer_first_name').val(customer.name.split(' ')[0]).prop('disabled', true);
                $('#new_customer_last_name').val(customer.name.split(' ')[1] || '').prop('disabled', true);
                $('#new_customer_phone_number').val(customer.phone).prop('disabled', true);
                $('#new_customer_email').val(customer.email).prop('disabled', true);
                $('#new_customer_address').val(customer.address).prop('disabled', true);
            } else if (itemType === 'vehicle') {
                resetCustomerVehicleSections(); // Reset both first
                const vehicle = $(this).data();
                vehicleIdInput.val(vehicle.id);
                vehicleStatusBadge.text('Existing').removeClass('bg-secondary').addClass('bg-success');
                $('#new_vehicle_license_plate').val(vehicle.regNo).prop('disabled', true);
                $('#new_vehicle_vin').val(vehicle.vin).prop('disabled', true);
                $('#new_vehicle_make').val(vehicle.make).prop('disabled', true);
                $('#new_vehicle_model').val(vehicle.model).prop('disabled', true);
                $('#new_vehicle_year').val(vehicle.year).prop('disabled', true);
                $('#new_vehicle_color').val(vehicle.color).prop('disabled', true);

                // Auto-populate customer if vehicle is selected
                if (vehicle.ownerId) {
                    customerIdInput.val(vehicle.ownerId);
                    customerStatusBadge.text('Existing (Linked)').removeClass('bg-secondary').addClass('bg-success');
                    // In a real app, you'd fetch customer details by ID here to populate fields
                    // For now, we'll just show the name if available from vehicle search result
                    $('#new_customer_first_name').val(vehicle.ownerName.split(' ')[0]).prop('disabled', true);
                    $('#new_customer_last_name').val(vehicle.ownerName.split(' ')[1] || '').prop('disabled', true);
                    // Disable other customer fields as they are linked
                    $('#new_customer_phone_number, #new_customer_email, #new_customer_address').prop('disabled', true);
                }

                // Auto-populate mileage and reported problem from existing vehicle data
                $('#mileage_in').val(vehicle.mileage);
                $('#reported_problem').val(vehicle.reportedProblem);
            }
        });

        // --- Photo Preview ---
        photoInput.on('change', function() {
            photoPreviewContainer.empty(); // Clear previous previews
            if (this.files && this.files.length > 0) {
                Array.from(this.files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            photoPreviewContainer.append(`<img src="${e.target.result}" alt="Photo Preview">`);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });

        // --- Form Submission ---
        jobIntakeForm.on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Clear previous error messages
            $('.error-message').text('');

            const formData = new FormData(this); // Create FormData object for AJAX file upload

            // Add loading state to button
            const submitButton = $(this).find('button[type="submit"]');
            submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating...');

            $.ajax({
                url: '<?= base_url('job_intake/create_job_card') ?>',
                method: 'POST',
                data: formData,
                processData: false, // Important for FormData
                contentType: false, // Important for FormData
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message + ' Job No: ' + response.job_no);
                        jobIntakeForm[0].reset(); // Reset form
                        resetCustomerVehicleSections(); // Reset customer/vehicle status
                        photoPreviewContainer.empty(); // Clear photo previews
                        // Optionally redirect or close modal
                        // window.location.href = '<?= base_url('admin/jobs/view/') ?>' + response.job_id;
                        // If this form is in a modal, you'd close the modal here:
                        // $('#actionModal').modal('hide');
                    } else {
                        alert('Error: ' + response.message);
                        if (response.errors) {
                            // Display validation errors
                            $.each(response.errors, function(key, value) {
                                const errorDiv = $('#error_' + key);
                                if (errorDiv.length) {
                                    errorDiv.text(value);
                                } else {
                                    console.error('Error div not found for:', key);
                                }
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'An unexpected error occurred. Please try again.';
                    try {
                        const responseJson = JSON.parse(xhr.responseText);
                        if (responseJson.message) {
                            errorMessage = 'Error: ' + responseJson.message;
                        } else if (responseJson.errors) {
                             errorMessage = 'Validation Error: ' + Object.values(responseJson.errors).join(', ');
                        }
                    } catch (e) {
                        // If response is not JSON, use generic message
                    }
                    alert(errorMessage);
                    console.error("AJAX error:", xhr.responseText);
                },
                complete: function() {
                    submitButton.prop('disabled', false).html('<i class="bi bi-plus-circle"></i> Create Job Card');
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>
