<!-- Add Vehicle Modal -->
<div id="addVehicleModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addVehicleForm" action="<?= base_url('admin/vehicles/add') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Registration No</label>
                            <input type="text" name="registration_no" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Make</label>
                            <input type="text" name="make" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Model</label>
                            <input type="text" name="model" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Year</label>
                            <input type="number" name="year" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Color</label>
                            <input type="text" name="color" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Engine No</label>
                            <input type="text" name="engine_no" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Chassis No</label>
                            <input type="text" name="chassis_no" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Save Vehicle
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Vehicle Details Modal -->
<div id="viewVehicleModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vehicle Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Registration No:</strong> <span id="v_registration_no"></span></p>
                        <p><strong>Make:</strong> <span id="v_make"></span></p>
                        <p><strong>Model:</strong> <span id="v_model"></span></p>
                        <p><strong>Year:</strong> <span id="v_year"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Color:</strong> <span id="v_color"></span></p>
                        <p><strong>Engine No:</strong> <span id="v_engine_no"></span></p>
                        <p><strong>Chassis No:</strong> <span id="v_chassis_no"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

