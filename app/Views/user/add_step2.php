<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>Add New User - Step 2: Personal Information</h5>
        </div>
        <div class="card-body">
            <form id="step2Form" method="POST" action="<?= base_url('user/add_step2') ?>">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                </div>

                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" required>
                </div>

                <div class="mb-3">
                    <label for="national_id" class="form-label">National ID Number</label>
                    <input type="text" class="form-control" id="national_id" name="national_id" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gender</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Male" required> Male
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Female"> Female
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" value="Other"> Other
                    </div>
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Home Address</label>
                    <input type="text" class="form-control" id="address" name="address" required>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" onclick="loadStep1()" class="btn btn-secondary">Previous</button>
                        <button type="submit" class="btn btn-primary">Next Step</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Navigate back to Step 1
    function loadStep1() {
        window.location.href = "<?= base_url('user/add_step1') ?>";
    }

    // AJAX Form Submission for Step 2
    $('#step2Form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= base_url('user/add_step2') ?>",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    window.location.href = "<?= base_url('user/add_step3') ?>";
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Failed to submit Step 2.');
            }
        });
    });
</script>