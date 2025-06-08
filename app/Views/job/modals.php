<!-- Add Job Modal -->
<div id="addJobModal" class="modal fade" tabindex="-1" aria-labelledby="addJobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addJobModalLabel">Add New Job</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Please fill in the details below to create a new job card.</p>
                <form id="jobIntakeForm" action="<?= base_url('job_intake/create_job_card') ?>" enctype="multipart/form-data" method="post">
                    <div class="mb-3 position-relative">
                        <label for="search_input" class="form-label">Search Customer/Vehicle</label>
                        <input type="text" class="form-control" id="search_input" placeholder="License Plate, VIN, or Phone Number">
                        <div class="error-message" id="error_search_input"></div>
                        <div id="search_results" class="search-results-dropdown hidden"></div>
                    </div>

                    <div class="my-4 border-top pt-4">
                        <div class="d-flex align-items-center mb-3">
                            <h5 class="text-primary mb-0">Customer Details</h5>
                            <span id="customer_status" class="badge bg-secondary ms-2">New</span>
                        </div>
                        <input type="hidden" id="customer_id" name="customer_id" value="new">
                        <div class="row g-2 mb-3">
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

                    <div class="my-4 border-top pt-4">
                        <div class="d-flex align-items-center mb-3">
                            <h5 class="text-primary mb-0">Vehicle Details</h5>
                            <span id="vehicle_status" class="badge bg-secondary ms-2">New</span>
                        </div>
                        <input type="hidden" id="vehicle_id" name="vehicle_id" value="new">
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label for="new_vehicle_license_plate" class="form-label">Reg No.</label>
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
                                <label for="new_vehicle_engine_number" class="form-label">Engine Number</label>
                                <input type="text" class="form-control" id="new_vehicle_engine_number" name="new_vehicle_engine_number" required>
                                <div class="error-message" id="error_new_vehicle_engine_number"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="new_vehicle_chassis_number" class="form-label">Chassis Number</label>
                                <input type="text" class="form-control" id="new_vehicle_chassis_number" name="new_vehicle_chassis_number" required>
                                <div class="error-message" id="error_new_vehicle_chassis_number"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="new_vehicle_fuel_type" class="form-label">Fuel Type</label>
                                <select class="form-select" id="new_vehicle_fuel_type" name="new_vehicle_fuel_type" required>
                                    <option value="">Select Fuel Type</option>
                                    <option value="Petrol">Petrol</option>
                                    <option value="Diesel">Diesel</option>
                                    <option value="Electric">Electric</option>
                                    <option value="Hybrid">Hybrid</option>
                                </select>
                                <div class="error-message" id="error_new_vehicle_fuel_type"></div>
                            </div>

                            <div class="col-md-6">
                                <label for="new_vehicle_color" class="form-label">Color (Optional)</label>
                                <input type="text" class="form-control" id="new_vehicle_color" name="new_vehicle_color">
                                <div class="error-message" id="error_new_vehicle_color"></div>
                            </div>
                        </div>
                    </div>

                    <div class="my-4 border-top pt-4">
                        <h5 class="mb-3 text-primary">Job Details</h5>
                        <div class="row g-2 mb-3">
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
                                        <option value="<?= esc($advisor['id'] ?? '') ?>">
                                            <?= esc(($advisor['first_name'] ?? '') . ' ' . ($advisor['last_name'] ?? '') . ' (' . ($advisor['company_id'] ?? '') . ')') ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="error-message" id="error_assigned_service_advisor_id"></div>
                            </div>
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
</div>

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.min.css">
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {
        // --- Element References ---
        const addJobModal = $('#addJobModal');
        const jobIntakeForm = $('#jobIntakeForm');
        const searchInput = $('#search_input');
        const searchResults = $('#search_results');
        const customerStatusBadge = $('#customer_status');
        const vehicleStatusBadge = $('#vehicle_status');
        const photoPreviewContainer = $('#photo_preview_container');
        const photoUploadInput = $('#job_card_photos');

        // Customer Fields
        const customerId = $('#customer_id');
        const newCustomerFirstName = $('#new_customer_first_name');
        const newCustomerLastName = $('#new_customer_last_name');
        const newCustomerPhone = $('#new_customer_phone_number');
        const newCustomerEmail = $('#new_customer_email');
        const newCustomerAddress = $('#new_customer_address');
        const allCustomerInputs = [newCustomerFirstName, newCustomerLastName, newCustomerPhone, newCustomerEmail, newCustomerAddress];

        // Vehicle Fields
        const vehicleId = $('#vehicle_id');
        const newVehicleLicensePlate = $('#new_vehicle_license_plate');
        const newVehicleVIN = $('#new_vehicle_vin');
        const newVehicleMake = $('#new_vehicle_make');
        const newVehicleModel = $('#new_vehicle_model');
        const newVehicleYear = $('#new_vehicle_year');
        const newVehicleEngineNumber = $('#new_vehicle_engine_number');
        const newVehicleChassisNumber = $('#new_vehicle_chassis_number');
        const newVehicleFuelType = $('#new_vehicle_fuel_type');
        const newVehicleColor = $('#new_vehicle_color');
        const allVehicleInputs = [newVehicleLicensePlate, newVehicleVIN, newVehicleMake, newVehicleModel, newVehicleYear, newVehicleEngineNumber, newVehicleChassisNumber, newVehicleFuelType, newVehicleColor];

        // Job Details Fields (for auto-population from existing vehicle)
        const reportedProblem = $('#reported_problem');
        const mileageIn = $('#mileage_in');
        const fuelLevel = $('#fuel_level');


        // --- Helper Functions ---

        // Function to display form-specific error messages
        function displayFormError(fieldId, message) {
            const errorDiv = $('#error_' + fieldId);
            if (errorDiv.length) {
                errorDiv.text(message);
                $('#' + fieldId).addClass('is-invalid');
            }
        }

        // Function to clear all form error messages and invalid states
        function clearFormErrors() {
            $('.error-message').text('');
            $('input, select, textarea').removeClass('is-invalid');
        }

        // Function to reset customer section to 'new' state
        function resetCustomerSection() {
            customerId.val('new');
            customerStatusBadge.text('New').removeClass('bg-success').addClass('bg-secondary');
            allCustomerInputs.forEach(input => {
                input.val('');
                input.prop('disabled', false);
            });
        }

        // Function to reset vehicle section to 'new' state
        function resetVehicleSection() {
            vehicleId.val('new');
            vehicleStatusBadge.text('New').removeClass('bg-success').addClass('bg-secondary');
            allVehicleInputs.forEach(input => {
                input.val('');
                input.prop('disabled', false);
            });
        }

        // Function to populate customer fields from search result data
        function populateCustomerFields(customerData) {
            resetCustomerSection(); // Always reset before populating
            customerId.val(customerData.id);
            customerStatusBadge.text('Existing').removeClass('bg-secondary').addClass('bg-success');

            const nameParts = (customerData.name || '').split(' ');
            newCustomerFirstName.val(nameParts[0] || '').prop('disabled', true);
            newCustomerLastName.val(nameParts[1] || '').prop('disabled', true);
            newCustomerPhone.val(customerData.phone || '').prop('disabled', true);
            newCustomerEmail.val(customerData.email || '').prop('disabled', true);
            newCustomerAddress.val(customerData.address || '').prop('disabled', true);
        }

        // Function to populate vehicle fields from search result data
        function populateVehicleFields(vehicleData) {
            resetVehicleSection(); // Always reset before populating
            vehicleId.val(vehicleData.id);
            vehicleStatusBadge.text('Existing').removeClass('bg-secondary').addClass('bg-success');

            newVehicleLicensePlate.val(vehicleData.registration_number || '').prop('disabled', true);
            newVehicleVIN.val(vehicleData.vin || '').prop('disabled', true);
            newVehicleMake.val(vehicleData.make || '').prop('disabled', true);
            newVehicleModel.val(vehicleData.model || '').prop('disabled', true);
            newVehicleYear.val(vehicleData.year_of_manufacture || '').prop('disabled', true);
            newVehicleEngineNumber.val(vehicleData.engine_number || '').prop('disabled', true);
            newVehicleChassisNumber.val(vehicleData.chassis_number || '').prop('disabled', true);
            newVehicleFuelType.val(vehicleData.fuel_type || '').prop('disabled', true);
            newVehicleColor.val(vehicleData.color || '').prop('disabled', true);

            // Auto-populate job details from existing vehicle data
            mileageIn.val(vehicleData.mileage || 0);
            reportedProblem.val(vehicleData.reported_problem || '');
        }

        // Reset entire form state on modal close or successful submission
        function resetEntireForm() {
            jobIntakeForm[0].reset(); // Resets all form fields
            resetCustomerSection();
            resetVehicleSection();
            photoPreviewContainer.empty();
            photoPreviewContainer.addClass('empty-state'); // Add empty state class
            searchResults.empty().hide();
            clearFormErrors();
        }

        // --- Event Listeners ---

        // Handle modal hidden event to reset form
        addJobModal.on('hidden.bs.modal', function() {
            resetEntireForm();
        });

        // Photo Upload Preview
        photoUploadInput.on('change', function() {
            photoPreviewContainer.empty();
            photoPreviewContainer.removeClass('empty-state');
            clearFormErrors(); // Clear errors for job_card_photos specifically

            const files = this.files;
            if (files.length === 0) {
                photoPreviewContainer.addClass('empty-state');
                return;
            }

            if (files.length > 10) {
                displayFormError('job_card_photos', "You can upload a maximum of 10 images.");
                this.value = ''; // Clear the input
                photoPreviewContainer.addClass('empty-state');
                return;
            }

            let allFilesValid = true;
            Array.from(files).forEach(file => {
                if (file.size > 2 * 1024 * 1024) { // 2MB
                    displayFormError('job_card_photos', `File "${file.name}" is too large. Max 2MB allowed.`);
                    this.value = ''; // Clear the input
                    photoPreviewContainer.empty();
                    photoPreviewContainer.addClass('empty-state');
                    allFilesValid = false;
                    return;
                }
                if (!file.type.startsWith('image/')) {
                    displayFormError('job_card_photos', `File "${file.name}" is not an image.`);
                    this.value = ''; // Clear the input
                    photoPreviewContainer.empty();
                    photoPreviewContainer.addClass('empty-state');
                    allFilesValid = false;
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreviewContainer.append(`<img src="${e.target.result}" class="preview-thumb" alt="Photo Preview">`);
                };
                reader.readAsDataURL(file);
            });

            if (!allFilesValid) {
                this.value = '';
                photoPreviewContainer.empty();
                photoPreviewContainer.addClass('empty-state');
            }
        });

        // Customer/Vehicle Search
        let searchTimeout;
        searchInput.on('keyup', function() {
            clearTimeout(searchTimeout);
            const query = $(this).val().trim();
            clearFormErrors(); // Clear errors on new search input

            if (query.length < 2) {
                searchResults.empty().hide();
                resetCustomerSection(); // Reset sections if search query is too short
                resetVehicleSection();
                return;
            }

            searchTimeout = setTimeout(function() {
                $.ajax({
                    url: '<?= base_url("job_intake/search") ?>',
                    method: 'GET',
                    data: { query: query },
                    dataType: 'json',
                    success: function(response) {
                        searchResults.empty();
                        if (response.customers.length === 0 && response.vehicles.length === 0) {
                            searchResults.append('<div class="search-result-item disabled">No existing matches. Will create new.</div>');
                        } else {
                            response.customers.forEach(customer => {
                                searchResults.append(`
                                    <div class="search-result-item" data-type="customer" data-id="${customer.id}"
                                        data-name="${customer.name}" data-phone="${customer.phone}"
                                        data-email="${customer.email || ''}" data-address="${customer.address || ''}">
                                        <div class="result-title">Customer: ${customer.name}</div>
                                        <div class="result-subtitle">Phone: ${customer.phone}</div>
                                    </div>
                                `);
                            });
                            response.vehicles.forEach(vehicle => {
                                searchResults.append(`
                                    <div class="search-result-item" data-type="vehicle" data-id="${vehicle.id}"
                                        data-registration_number="${vehicle.registration_number}"
                                        data-vin="${vehicle.vin || ''}" data-make="${vehicle.make}" data-model="${vehicle.model}"
                                        data-year_of_manufacture="${vehicle.year_of_manufacture}"
                                        data-color="${vehicle.color || ''}" data-mileage="${vehicle.mileage || 0}"
                                        data-reported_problem="${vehicle.reported_problem || ''}"
                                        data-engine_number="${vehicle.engine_number || ''}" data-chassis_number="${vehicle.chassis_number || ''}"
                                        data-fuel_type="${vehicle.fuel_type || ''}" data-transmission="${vehicle.transmission || ''}"
                                        data-owner-id="${vehicle.owner_id}" data-owner-name="${vehicle.owner_name || ''}"
                                        data-owner-phone="${(vehicle.owner && vehicle.owner.phone) ? vehicle.owner.phone : ''}"
                                        data-owner-email="${(vehicle.owner && vehicle.owner.email) ? vehicle.owner.email : ''}"
                                        data-owner-address="${(vehicle.owner && vehicle.owner.address) ? vehicle.owner.address : ''}">
                                        <div class="result-title">Vehicle: ${vehicle.registration_number} (${vehicle.make} ${vehicle.model})</div>
                                        <div class="result-subtitle">Owner: ${vehicle.owner_name}</div>
                                    </div>
                                `);
                            });
                        }
                        searchResults.show();
                    },
                    error: function(xhr, status, error) {
                        searchResults.empty().hide();
                        displayFormError('search_input', 'Error performing search. Please try again.');
                    }
                });
            }, 300); // 300ms debounce
        });

        // Handle selection from search results
        searchResults.on('click', '.search-result-item:not(.disabled)', function() {
            const itemType = $(this).data('type');
            const itemData = $(this).data(); // Get all data- attributes as an object

            searchResults.empty().hide();
            searchInput.val($(this).find('.result-title').text()); // Set search input to selected item's title

            clearFormErrors(); // Clear errors on selection

            if (itemType === 'customer') {
                resetCustomerSection();
                populateCustomerFields({
                    id: itemData.id,
                    name: itemData.name,
                    phone: itemData.phone,
                    email: itemData.email,
                    address: itemData.address
                });
                // Ensure vehicle section is reset to new if only customer is selected
                resetVehicleSection();
            } else if (itemType === 'vehicle') {
                resetVehicleSection();
                // Pass data directly to populateVehicleFields, using the original names
                populateVehicleFields(itemData);

                // If vehicle has an owner, populate customer section with full details
                if (itemData.ownerId) {
                    populateCustomerFields({
                        id: itemData.ownerId,
                        name: itemData.ownerName,
                        phone: itemData.ownerPhone,
                        email: itemData.ownerEmail,
                        address: itemData.ownerAddress
                    });
                    // Disable customer fields when linked to an existing vehicle
                    allCustomerInputs.forEach(input => input.prop('disabled', true));
                } else {
                    // If vehicle has no owner, reset customer section to new
                    resetCustomerSection();
                }
            }
        });

        // Hide dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#search_input, #search_results').length) {
                searchResults.hide();
            }
        });

        // Form Submission
        jobIntakeForm.on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            clearFormErrors(); // Clear all previous errors

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
                        Swal.fire({
                            title: 'Success!',
                            text: response.message + ' Job No: ' + response.job_no,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            resetEntireForm(); // Reset form and sections
                            addJobModal.modal('hide'); // Close the modal
                            window.location.reload(); // Reload the page to reflect new job
                        });
                    } else if (response.status === 'error') {
                        let errorMessage = 'Error: ' + (response.message || 'An unknown error occurred.');
                        if (response.errors) {
                            errorMessage = 'Validation failed. Please check the form.';
                            $.each(response.errors, function(key, value) {
                                displayFormError(key, value);
                            });
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'An unexpected server error occurred. Please try again.';
                    try {
                        const responseJson = JSON.parse(xhr.responseText);
                        if (responseJson.message) {
                            errorMessage = 'Server Error: ' + responseJson.message;
                        } else if (responseJson.errors) {
                            errorMessage = 'Validation Error: Please correct the following issues:<br>' + Object.values(responseJson.errors).join('<br>');
                            $.each(responseJson.errors, function(key, value) {
                                displayFormError(key, value);
                            });
                        }
                    } catch (e) {
                        // If response is not JSON, use generic message
                    }
                    Swal.fire({
                        title: 'Server Error!',
                        html: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                },
                complete: function() {
                    submitButton.prop('disabled', false).html('<i class="bi bi-plus-circle"></i> Create Job Card');
                }
            });
        });
    });
</script>

<style>
    /* Add any specific styles for this form if needed, e.g., for input focus, button colors */
    .form-group label {
        font-weight: 500;
        color: #343a40; /* text-dark */
    }
    .form-control:focus, .form-select:focus, .form-control:focus-within {
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
        padding: 1rem 1.5rem; /* Slightly reduced padding */
    }

    /* Search Results Dropdown */
    .search-results-dropdown {
        position: absolute;
        width: calc(100% - 2rem); /* Account for card padding */
        max-height: 200px;
        overflow-y: auto;
        background: white;
        border: 1px solid #ced4da;
        border-top: none;
        z-index: 1000;
        border-radius: 0 0 8px 8px;
        box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        left: 1rem; /* Align with card padding */
        right: 1rem;
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
    .search-results-dropdown .disabled {
        cursor: not-allowed;
        color: #999;
        font-style: italic;
    }

    /* Photo Preview */
    .photo-preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
        min-height: 110px; /* Give it a minimum height to avoid layout shifts */
        border: 1px dashed #ced4da; /* Visual cue for drop area */
        border-radius: 8px;
        padding: 10px;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: #6c757d;
        font-size: 0.9rem;
    }
    .photo-preview-container.empty-state::before {
        content: "No photos selected. Click or drag to add.";
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
    .form-control.is-invalid, .form-select.is-invalid, textarea.is-invalid {
        border-color: #dc3545 !important;
    }
</style>
