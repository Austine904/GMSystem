$(document).ready(function () {
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
    photoUploadInput.on('change', function () {
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
            reader.onload = function (e) {
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
    customerSearchInput.on('keyup', function () {
        const query = $(this).val().trim();
        if (!query) return;

        $.ajax({
            type: 'GET',
            url: '/job_intake/search',
            data: { query },
            success: function (response) {
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
            error: function () {
                alert('Error searching customer.');
            }
        });
    });

    // Vehicle Search
    vehicleSearchInput.on('keyup', function () {
        const query = $(this).val().trim();
        if (!query) return;

        $.ajax({
            type: 'GET',
            url: 'job_intake/vehicle_search',
            data: { query },
            success: function (response) {
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
            error: function () {
                alert('Error searching vehicle.');
            }
        });
    });

    //  Auto-fill customer from vehicle selection
    function fetchCustomerById(customerId) {
        $.ajax({
            type: 'GET',
            url: 'job_intake/get_customer_by_id',
            data: { id: customerId },
            success: function (response) {
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
            error: function () {
                console.warn('Failed to fetch customer by ID');
            }
        });
    }

    //  Form Submit
    jobForm.on('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: 'job_intake/save',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
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
            error: function () {
                alert('Something went wrong while saving job.');
            }
        });
    });

    jobForm.on('reset', function () {
        resetFormState();
        photoPreviewContainer.empty();
    }
    );

    $(document).ready(function () {
        $('#search_input').on('keyup', function () {
            let query = $(this).val().trim();
            let resultBox = $('#search_results');

            if (query.length < 2) {
                resultBox.empty().hide();
                return;
            }

            $.ajax({
                url: '<?= base_url("admin/job_intake/search") ?>',
                method: 'GET',
                data: { search: query },
                success: function (data) {
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
        $(document).on('click', '.search-result-item', function () {
            const selectedLabel = $(this).text();
            const selectedId = $(this).data('id');

            $('#search_input').val(selectedLabel);
            $('#search_results').hide();

            // Optional: Store selected ID for later
            console.log("Selected ID:", selectedId);
        });

        // Hide dropdown when clicking outside
        $(document).on('click', function (e) {
            if (!$(e.target).closest('#search_input, #search_results').length) {
                $('#search_results').hide();
            }
        });
    });
});
