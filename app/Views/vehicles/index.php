<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <h3 class="mb-4">Vehicle Management</h3>

    <!-- Add Vehicle Button -->
    <!-- <button class="btn btn-primary mb-3" onclick="openAddModal()">Add Vehicle</button> -->
    <button onclick="$('#addVehicleModal').modal('show')" class="btn btn-outline-primary mb-3">
        <i class="bi bi-plus-lg"></i> Add Vehicle
    </button>

    <!-- Vehicle Table -->
    <table id="vehicleTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vehicle Number</th>
                <th>Make</th>
                <th>Model</th>
                <th>Year of manufature</th>
                <th>Engine Number</th>
                <th>Chassis Number</th>
                
                <th>Color</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>


</div>


<!-- Modals -->
<?php include('modals.php'); ?>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        const table = $('#vehicleTable').DataTable({
            "ajax": "<?= base_url('vehicles/fetch') ?>",
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "registration_number"
                },
                {
                    "data": "make"
                },
                {
                    "data": "model"
                },
                {
                    "data": "year_of_manufacture"
                },
                {
                    "data": "engine_number"
                },
                {
                    "data": "chassis_number"
                },
                {
                    "data": "color"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "updated_at"
                },
                {
                    "data": "status"
                },
                {
                    "data": "owner_id",
                },
                {
                    "data": null,
                    "render": function(data, type, row) {
                        return `
                            <button class="btn btn-sm btn-primary" onclick="editVehicle(${data.id})">Edit</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteVehicle(${data.id})">Delete</button>
                        `;
                    }
                }
            ]
        });

        // Add Vehicle AJAX
        $('#addVehicleForm').on('click', function() {
            const formData = $('#addVehicleForm').serialize();
            $.post("<?= base_url('admin/vehicles/add') ?>", formData, function(response) {
                $('#vehicleModal').modal('hide');
                table.ajax.reload();
            });
        });

        // Edit Vehicle AJAX
        window.editVehicle = function(id) {
            $.get(`<?= base_url('vehicles/fetch') ?>/${id}`, function(data) {
                $('#vehicle_id').val(data.id);
                $('#vehicle_number').val(data.vehicle_number);
                $('#make').val(data.make);
                $('#model').val(data.model);
                $('#year').val(data.year);
                $('#color').val(data.color);
                $('#vehicleModal').modal('show');
            });
        };

        // Delete Vehicle AJAX
        window.deleteVehicle = function(id) {
            if (confirm("Are you sure you want to delete this vehicle?")) {
                $.post(`<?= base_url('vehicles/delete') ?>/${id}`, function(response) {
                    table.ajax.reload();
                });
            }
        };

        // Clear form when modal closes
        $('#vehicleModal').on('hidden.bs.modal', function() {
            $('#vehicleForm')[0].reset();
        });
    });

    function openAddModal() {
        const modal = new bootstrap.Modal(document.getElementById('vehicleModal'));
        modal.show();
    }

    $('#addVehicleForm').submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            alert('Vehicle added successfully!');
            $('#addVehicleModal').modal('hide');
            $('#vehiclesTable').DataTable().ajax.reload();
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert('Failed to add vehicle.');
        }
    });
});


    function viewVehicleDetails(id) {
        $.ajax({
            url: "<?= base_url('vehicles/details') ?>/" + id,
            method: 'GET',
            success: function(data) {
                $('#viewVehicleModal .modal-body').html(`
                    <p><strong>Vehicle Number:</strong> ${data.vehicle_number}</p>
                    <p><strong>Make:</strong> ${data.make}</p>
                    <p><strong>Model:</strong> ${data.model}</p>
                    <p><strong>Year:</strong> ${data.year}</p>
                    <p><strong>Color:</strong> ${data.color}</p>
                `);
                $('#viewVehicleModal').modal('show');
            },
            error: function(error) {
                alert('Failed to fetch vehicle details.');
                console.error(error);
            }
        });
    }
    function deleteVehicle(id) {
        if (confirm('Are you sure you want to delete this vehicle?')) {
            $.ajax({
                url: "<?= base_url('vehicles/delete') ?>/" + id,
                method: 'DELETE',
                success: function(response) {
                    alert('Vehicle deleted successfully!');
                    // Reload DataTable
                    $('#vehiclesTable').DataTable().ajax.reload();
                },
                error: function(error) {
                    alert('Failed to delete vehicle.');
                    console.error(error);
                }
            });
        }
    }
</script>

<?= $this->endSection() ?>