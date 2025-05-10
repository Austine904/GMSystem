
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5>Add New User - Step 2: Personal Information</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= base_url('user/add_step2') ?>">

                <!-- First Name -->
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                </div>

                <!-- Last Name -->
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                </div>

                <!-- Date of Birth -->
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" required>
                </div>

                <!-- National ID Number -->
                <div class="mb-3">
                    <label for="national_id" class="form-label">National ID Number</label>
                    <input type="text" class="form-control" id="national_id" name="national_id" required>
                </div>

                <!-- Gender -->
                <div class="mb-3">
                    <label class="form-label">Gender</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="Male" required>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="Female">
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="other" value="Other">
                        <label class="form-check-label" for="other">Other</label>
                    </div>
                </div>

                <!-- Phone Number -->
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <!-- Navigation Buttons -->
                <div class="d-flex justify-content-between">
                    <button type="button" onclick="goBackToStep1()" class="btn btn-secondary">Previous</button>
                    <button type="submit" class="btn btn-primary">Next Step</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function goBackToStep1() {
        window.location.href = "<?= base_url('user/add_step1') ?>";
    }
</script>

