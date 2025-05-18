<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>Add New User - Step 1: Company Info</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= base_url('user/add_step1') ?>" enctype="multipart/form-data">

                <!-- Image Upload -->
                <div class="mb-3">
                    <label for="profile_picture" class="form-label">User Image</label>
                    <input class="form-control" type="file" id="profile_picture" name="profile_picture" accept="image/*" required>
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

                <!-- <div class="mb-3" id="passwordField" style="display: none;">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div> -->


                <!-- Company ID (Read-only) -->
                <div class="mb-3">
                    <label for="company_id" class="form-label">Company ID</label>
                    <input type="text" class="form-control" id="company_id" name="company_id" readonly>
                    <small class="form-text text-muted">Generated based on role and current year.</small>
                </div>

                <!-- Date of Employment (Read-only) -->
                <div class="mb-3">
                    <label for="date_of_employment" class="form-label">Date of Employment</label>
                    <input type="text" class="form-control" id="date_of_employment" name="date_of_employment" readonly value="<?= date('Y-m-d') ?>">
                </div>

                <!-- Buttons -->
                <div class="d-flex justify-content-between">
                    <button type="button" id="nextStep" class="btn btn-primary">Next Step</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Fetch and generate company ID
    document.getElementById('role').addEventListener('change', function() {
        const role = this.value;
        const year = new Date().getFullYear().toString().slice(-2);

        // Define the prefixes for each role
        const rolePrefixes = {
            admin: 'ADM',
            mechanic: 'MECH',
            receptionist: 'RP'
        };

        // Fetch the last ID for the selected role
        fetch("<?= base_url('user/getLastId') ?>?role=" + role, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                // Get the last ID from the response and increment it
                const lastId = parseInt(data.result) + 1;

                // Format the ID to 3 digits (e.g., 001, 002, etc.)
                const formattedId = String(lastId).padStart(3, '0');

                // Use the appropriate prefix based on the role
                const companyId = `${rolePrefixes[role]}${year}${formattedId}`;

                // Populate the fields
                document.getElementById('company_id').value = companyId;
                document.getElementById('company_id').setAttribute('readonly', true);
                document.getElementById('date_of_employment').value = new Date().toISOString().split('T')[0];
            })
            .catch(error => console.error('Error:', error));
    });

    // Submit Step 1 and go to Step 2
    document.getElementById('nextStep').addEventListener('click', function() {
        const form = document.querySelector('form');
        const formData = new FormData(form);

        // Add CSRF token if needed
        formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

        fetch("<?= base_url('user/add_step1') ?>", {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = "<?= base_url('user/add_step2') ?>";
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));

        // document.getElementById('role').addEventListener('change', function() {
        //     const role = this.value;
        //     const passwordField = document.getElementById('passwordField');


        //     if (role === 'Admin' || role === 'Receptionist') {
        //         passwordField.style.display = 'block';
        //     } else {
        //         passwordField.style.display = 'none';
        //         document.getElementById('password').value = '';
        //     }
        // });
    });
</script>

<?php
$hashedPassword = password_hash('123456', PASSWORD_DEFAULT);

echo "<script>
    console.log('Hashed Password: $hashedPassword');
</script>";
