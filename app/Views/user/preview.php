<!DOCTYPE html>
<html>

<head>
    <title>User Preview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTTXRNpBfhneMjbWqE7Xw6jTqZTbIc1U7bI2zZZK/1yXQDQefO8c8jGvhW5SttIV5EVz6zWQwg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .edit-icon {
            cursor: pointer;
            margin-left: 5px;
            color: #007bff;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5>Preview User Details</h5>
            </div>
            <div class="card-body">

                <!-- Company Information -->
                <h6 class="text-muted">
                    Company Information 
                    <i class="fas fa-edit edit-icon" onclick="editStep(1)"></i>
                </h6>
                <div class="mb-3">
                    <label for="profile_picture" class="form-label"><strong>Profile Picture:</strong></label>
                    <div>
                        <img id="previewImage"
                            src="<?= session()->get('step1_data')['profile_picture'] ? base_url(session()->get('step1_data')['profile_picture']) : base_url('uploads/default.png') ?>"
                            alt="Profile Picture" style="max-width: 150px; border-radius: 8px;" />
                    </div>
                </div>
                <p><strong>Role:</strong> <?= session('step1_data.role') ?></p>
                <p><strong>Company ID:</strong> <?= session('step1_data.company_id') ?></p>
                <p><strong>Date of Employment:</strong> <?= session('step1_data.date_of_employment') ?></p>

                <hr>

                <!-- Personal Information -->
                <h6 class="text-muted">
                    Personal Information 
                    <i class="fas fa-edit edit-icon" onclick="editStep(2)"></i>
                </h6>
                <p><strong>First Name:</strong> <?= session('step2_data.first_name') ?></p>
                <p><strong>Last Name:</strong> <?= session('step2_data.last_name') ?></p>
                <p><strong>Date of Birth:</strong> <?= session('step2_data.dob') ?></p>
                <p><strong>National ID:</strong> <?= session('step2_data.national_id') ?></p>
                <p><strong>Gender:</strong> <?= session('step2_data.gender') ?></p>
                <p><strong>Phone Number:</strong> <?= session('step2_data.phone_number') ?></p>
                <p><strong>Home Address:</strong> <?= session('step2_data.address') ?></p>
                <p><strong>Email Address:</strong> <?= session('step2_data.email') ?></p>

                <hr>

                <!-- Next of Kin Information -->
                <h6 class="text-muted">
                    Next of Kin Information 
                    <i class="fas fa-edit edit-icon" onclick="editStep(3)"></i>
                </h6>
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

        // Navigate back to specific step for editing
        function editStep(step) {
            switch (step) {
                case 1:
                    window.location.href = "<?= base_url('user/add_step1') ?>";
                    break;
                case 2:
                    window.location.href = "<?= base_url('user/add_step2') ?>";
                    break;
                case 3:
                    window.location.href = "<?= base_url('user/add_step3') ?>";
                    break;
            }
        }
    </script>

</body>

</html>
