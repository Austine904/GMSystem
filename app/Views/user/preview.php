<!DOCTYPE html>
<html>
<head>
    <title>User Preview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>Preview User Details</h5>
        </div>
        <div class="card-body">
            <h6 class="text-muted">Company Information</h6>
            <p><strong>Profile Picture:</strong></p>
            <img src="<?= base_url('uploads/' . session('step1_data.profile_picture')) ?>" alt="Profile Picture" class="img-thumbnail mb-3" style="width: 150px; height: 150px;">
            <img src="<?= base_url('uploads/users' . session('step1_data.profile_picture')) ?>" alt="Profile Picture" class="img-thumbnail mb-3" style="width: 150px; height: 150px;">
            <p><strong>Role:</strong> <?= session('step1_data.role') ?></p>
            <p><strong>Company ID:</strong> <?= session('step1_data.company_id') ?></p>
            <p><strong>Date of Employment:</strong> <?= session('step1_data.date_of_employment') ?></p>

            <hr>

            <h6 class="text-muted">Personal Information</h6>
            <p><strong>First Name:</strong> <?= session('step2_data.first_name') ?></p>
            <p><strong>Last Name:</strong> <?= session('step2_data.last_name') ?></p>
            <p><strong>Date of Birth:</strong> <?= session('step2_data.dob') ?></p>
            <p><strong>National ID:</strong> <?= session('step2_data.national_id') ?></p>
            <p><strong>Gender:</strong> <?= session('step2_data.gender') ?></p>
            <p><strong>Phone Number:</strong> <?= session('step2_data.phone_number') ?></p>
            <p><strong>Home Address:</strong> <?= session('step2_data.address') ?></p>
            <p><strong>Email Address:</strong> <?= session('step2_data.email') ?></p>

            <hr>

            <h6 class="text-muted">Next of Kin Information</h6>
            <p><strong>First Name:</strong> <?= session('step3_data.kin_first_name') ?></p>
            <p><strong>Last Name:</strong> <?= session('step3_data.kin_last_name') ?></p>
            <p><strong>Relationship:</strong> <?= session('step3_data.relationship') ?></p>
            <p><strong>Phone Number:</strong> <?= session('step3_data.kin_phone_number') ?></p>

            <hr>

            <!-- Buttons -->
            <div class="d-flex justify-content-between">
                <button type="button" onclick="goBackToStep3()" class="btn btn-secondary">Previous</button>
                <button type="button" onclick="finalSubmit()" class="btn btn-success">Confirm & Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    function goBackToStep3() {
        window.location.href = "<?= base_url('user/add_step3') ?>";
    }

    function finalSubmit() {
        if (confirm('Are you sure you want to save this user?')) {
            window.location.href = "<?= base_url('user/saveUser') ?>";
        }
    }
</script>

</body>
</html>
