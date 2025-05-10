<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>Add New User - Step 1: Company Info</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= base_url('user/add_step1') ?>" enctype="multipart/form-data">
                
                <!-- Image Upload -->
                <div class="mb-3">
                    <label for="userImage" class="form-label">User Image</label>
                    <input class="form-control" type="file" id="userImage" name="user_image" accept="image/*" required>
                </div>

                <!-- Role Selection -->
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" name="role" id="role" required>
                        <option value="" disabled selected>Select Role</option>
                        <option value="admin">Admin</option>
                        <option value="mechanic">Mechanic</option>
                        <option value="receptionist">Receptionist</option>
                    </select>
                </div>

                <!-- Company ID (Read-only) -->
                <div class="mb-3">
                    <label for="company_id" class="form-label">Company ID</label>
                    <input type="text" class="form-control" id="company_id" name="company_id" readonly>
                </div>

                <!-- Date of Employment (Read-only) -->
                <div class="mb-3">
                    <label for="employment_date" class="form-label">Date of Employment</label>
                    <input type="text" class="form-control" id="employment_date" name="employment_date" readonly value="<?= date('Y-m-d') ?>">
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary">Back</button>
                    <button type="submit" id="nextStep" class="btn btn-primary">Next Step</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('role').addEventListener('change', function() {
        const role = this.value;
        const year = new Date().getFullYear().toString().slice(-2);

        fetch("<?= base_url('user/getLastId') ?>/" + role)
            .then(response => response.json())
            .then(data => {
                const lastId = (parseInt(data.last_id) + 1).toString().padStart(3, '0');
                let prefix = "";
                
                if (role === 'admin') prefix = "ADM";
                else if (role === 'mechanic') prefix = "MECH";
                else if (role === 'receptionist') prefix = "RP";

                document.getElementById('company_id').value = prefix + year + lastId;
            })
            .catch(error => console.error('Error:', error));
    });
</script>
