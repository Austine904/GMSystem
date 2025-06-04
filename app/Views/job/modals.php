<!-- Add Vehicle Modal -->
<div id="addJobModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Job</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Please fill in the details below to create a new job card.</p>
                <form id="jobIntakeForm" action="<?= base_url('admin/jobs/add') ?>" enctype="multipart/form-data" method="post">
                    <div class="mb-4">
                        <label for="search_input" class="form-label">Search Customer/Vehicle</label>
                        <input type="text" class="form-control" id="search_input" placeholder="License Plate, VIN, or Phone Number">
                        <div id="search_results" class="search-results-item"></div>
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
                                    <option value="<?= esc($advisor['company_id']) ?>"><?= esc($advisor['first_name'] . ' ' . $advisor['last_name'] . ' ' . $advisor['company_id']) ?></option>
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
</div>

<script>
    $(document).ready(function() {
        const customerModal = $('#customerModal');
        const vehicleModal = $('#vehicleModal');
        const jobForm = $('#jobForm');
        const vehicleSection = $('#vehicleSection');
        const customerSection = $('#customerSection');
        const photoPreviewContainer = $('#photoPreview');
        const customerSearchInput = $('#search_input');
        const vehicleSearchInput = $('#vehicle_search_input');

        const customerIdField = $('#customer_id');
        const customerFirstName = $('#customer_first_name');
        const customerLastName = $('#customer_last_name');
        const customerPhone = $('#customer_phone');
        const customerEmail = $('#customer_email');

        const vehicleIdField = $('#vehicle_id');
        const vehicleMake = $('#vehicle_make');
        const vehicleModel = $('#vehicle_model');
        const vehicleRegNo = $('#vehicle_reg_no');

        const photoUploadInput = $('#photoUpload');
        const cancelCustomerBtn = $('#cancelCustomerBtn');
        const cancelVehicleBtn = $('#cancelVehicleBtn');

        function resetCustomerSection() {
            customerIdField.val('');
            customerFirstName.val('');
            customerLastName.val('');
            customerPhone.val('');
            customerEmail.val('');
            customerSection.addClass('d-none');
        }

        function resetVehicleSection() {
            vehicleIdField.val('');
            vehicleMake.val('');
            vehicleModel.val('');
            vehicleRegNo.val('');
            vehicleSection.addClass('d-none');
        }

        function resetFormState() {
            resetCustomerSection();
            resetVehicleSection();
            photoUploadInput.val('');
            photoPreviewContainer.empty();
        }

        // Photo Upload Preview with validation
        photoUploadInput.on('change', function() {
            const files = this.files;

            if (files.length > 10) {
                alert("You can upload a maximum of 10 images.");
                this.value = '';
                photoPreviewContainer.empty();
                return;
            }

            photoPreviewContainer.empty();

            Array.from(files).forEach(file => {
                if (file.size > 2 * 1024 * 1024) { // 2MB
                    alert(`File "${file.name}" is too large. Max 2MB allowed.`);
                    this.value = '';
                    photoPreviewContainer.empty();
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageHtml = `<img src="${e.target.result}" class="preview-thumb" alt="Photo Preview">`;
                    photoPreviewContainer.append(imageHtml);
                };
                reader.readAsDataURL(file);
            });
        });

        // Cancel Buttons
        cancelCustomerBtn.on('click', resetCustomerSection);
        cancelVehicleBtn.on('click', resetVehicleSection);

        // Customer Search
        customerSearchInput.on('keyup', function() {
            const query = $(this).val().trim();
            if (!query) return;

            $.ajax({
                "type": 'GET',
                "url": '<?= base_url('job_intake/search') ?>',
                "data": {
                    query
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status && data.customers.length > 0) {
                        const customer = data.customers[0];
                        const nameParts = (customer.name || '').split(' ');
                        const firstName = nameParts[0] || '';
                        const lastName = nameParts[1] || '';

                        customerIdField.val(customer.id);
                        customerFirstName.val(firstName);
                        customerLastName.val(lastName);
                        customerPhone.val(customer.phone_number);
                        customerEmail.val(customer.email);
                        customerSection.removeClass('d-none');
                        customerModal.modal('hide');
                    } else {
                        alert('Customer not found.');
                        resetCustomerSection();
                    }
                },
                error: function() {
                    alert('Error searching customer.');
                }
            });
        });

        // Vehicle Search
        vehicleSearchInput.on('keyup', function() {
            const query = $(this).val().trim();
            if (!query) return;

            $.ajax({
                "type": 'GET',
                "url": '<?= base_url('job_intake/vehicle_search') ?>',
                "data": {
                    query
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status && data.vehicles.length > 0) {
                        const vehicle = data.vehicles[0];

                        vehicleIdField.val(vehicle.id);
                        vehicleMake.val(vehicle.make);
                        vehicleModel.val(vehicle.model);
                        vehicleRegNo.val(vehicle.registration_number);
                        vehicleSection.removeClass('d-none');
                        vehicleModal.modal('hide');

                        // 🧠 Auto-fill customer too (nice touch for UX!)
                        if (vehicle.owner_id) {
                            fetchCustomerById(vehicle.owner_id);
                        }
                    } else {
                        alert('Vehicle not found.');
                        resetVehicleSection();
                    }
                },
                error: function() {
                    alert('Error searching vehicle.');
                }
            });
        });

        //  Auto-fill customer from vehicle selection
        function fetchCustomerById(customerId) {
            $.ajax({
                "type": 'GET',
                "url": '<?= base_url('job_intake/get_customer_by_id') ?>',
                "data": {
                    "id": customerId
                },
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status) {
                        const customer = data.customer;
                        const nameParts = (customer.name || '').split(' ');
                        const firstName = nameParts[0] || '';
                        const lastName = nameParts[1] || '';

                        customerIdField.val(customer.id);
                        customerFirstName.val(firstName);
                        customerLastName.val(lastName);
                        customerPhone.val(customer.phone_number);
                        customerEmail.val(customer.email);
                        customerSection.removeClass('d-none');
                    }
                },
                error: function() {
                    console.warn('Failed to fetch customer by ID');
                }
            });
        }

        //  Form Submit
        jobForm.on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: '<?= base_url('job_intake/save') ?>',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    const data = JSON.parse(response);

                    // 🔍 Clear previous errors
                    $('[id^="error_"]').text('');

                    if (data.status === 'success') {
                        alert(data.message);
                        jobForm.trigger('reset');
                        resetFormState();
                    } else if (data.status === 'error') {
                        for (const [key, value] of Object.entries(data.errors)) {
                            const errorDiv = $('#error_' + key);
                            if (errorDiv.length) {
                                errorDiv.text(value);
                            } else {
                                alert(`Form error: ${value}`);
                            }
                        }
                    }
                },
                error: function() {
                    alert('Something went wrong while saving job.');
                }
            });
        });

        jobForm.on('reset', function() {
            resetFormState();
            photoPreviewContainer.empty();
        });

        $(document).ready(function() {
            $('#search_input').on('keyup', function() {
                let query = $(this).val().trim();
                let resultBox = $('#search_results');

                if (query.length < 2) {
                    resultBox.empty().hide();
                    return;
                }

                $.ajax({
                    "url": '<?= base_url("admin/job_intake/search") ?>',
                    "method": 'GET',
                    "data": {
                        "search": query
                    },
                    success: function(data) {
                        resultBox.empty().show();

                        if (data.length === 0) {
                            resultBox.append('<div class="search-result-item disabled">No matches found</div>');
                        } else {
                            data.forEach(item => {
                                resultBox.append(`<div class="search-result-item" data-id="${item.value}">${item.label}</div>`);
                            });
                        }
                    }
                });
            });

            // When a result is clicked
            $(document).on('click', '.search-result-item', function() {
                const selectedLabel = $(this).text();
                const selectedId = $(this).data('id');

                $('#search_input').val(selectedLabel);
                $('#search_results').hide();

                // Optional: Store selected ID for later
                console.log("Selected ID:", selectedId);
            });

            // Hide dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#search_input, #search_results').length) {
                    $('#search_results').hide();
                }
            });
        });
    });
</script>