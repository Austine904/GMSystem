<!DOCTYPE html>
<html>

<head>
  <title>Add New User - Multi-Step Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

  <div class="container mt-5">
    <h3>Add New User - Multi-Step Form</h3>

    <form id="multiStepForm" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <!-- Step 1 -->
      <div id="step1" class="step-content">
        <h5>Step 1: Company Information</h5>

        <div class="mb-3">
          <label for="profile_picture" class="form-label">User Image</label>
          <input class="form-control" type="file" id="profile_picture" name="profile_picture" accept="image/*" required />
        </div>

        <div class="mb-3">
          <label for="role" class="form-label">Role</label>
          <select class="form-select" name="role" id="role" required>
            <option value="" disabled selected>Select Role</option>
            <option value="admin">Admin</option>
            <option value="mechanic">Mechanic</option>
            <option value="receptionist">Receptionist</option>
          </select>
        </div>

        <div class="mb-3" id="passwordField" style="display:none;">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" />
        </div>

        <div class="mb-3">
          <label for="company_id" class="form-label">Company ID</label>
          <input type="text" class="form-control" id="company_id" name="company_id" readonly />
          <small class="form-text text-muted">Generated based on role and current year.</small>
        </div>

        <div class="mb-3">
          <label for="date_of_employment" class="form-label">Date of Employment</label>
          <input type="text" class="form-control" id="date_of_employment" name="date_of_employment" readonly
            value="<?= date('Y-m-d') ?>" />
        </div>

        <button type="button" id="nextStep" class="btn btn-primary">Next Step</button>
      </div>

      <!-- Step 2 -->
      <div id="step2" class="step-content" style="display:none;">
        <h5>Step 2: Personal Information</h5>
 
        <div class="mb-3">
          <label for="first_name" class="form-label">First Name</label>
          <input type="text" class="form-control" id="first_name" name="first_name" required />
        </div>

        <div class="mb-3">
          <label for="last_name" class="form-label">Last Name</label>
          <input type="text" class="form-control" id="last_name" name="last_name" required />
        </div>

        <div class="mb-3">
          <label for="dob" class="form-label">Date of Birth</label>
          <input type="date" class="form-control" id="dob" name="dob" required />
        </div>

        <div class="mb-3">
          <label for="national_id" class="form-label">National ID Number</label>
          <input type="text" class="form-control" id="national_id" name="national_id" required />
        </div>

        <div class="mb-3">
          <label class="form-label">Gender</label><br />
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" value="Male" required /> Male
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" value="Female" /> Female
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" value="Other" /> Other
          </div>
        </div>

        <div class="mb-3">
          <label for="phone_number" class="form-label">Phone Number</label>
          <input type="text" class="form-control" id="phone_number" name="phone_number" required />
        </div>

        <div class="mb-3">
          <label for="address" class="form-label">Home Address</label>
          <input type="text" class="form-control" id="address" name="address" required />
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control" id="email" name="email" required />
        </div>

        <div class="d-flex justify-content-between">
          <button type="button" id="prevStep2" class="btn btn-secondary">Previous</button>
          <button type="button" id="nextStep2" class="btn btn-primary">Next Step</button>
        </div>
      </div>

      <!-- Step 3 -->
      <div id="step3" class="step-content" style="display:none;">
        <h5>Step 3: Next of Kin Information</h5>

        <div class="mb-3">
          <label for="kin_first_name" class="form-label">First Name</label>
          <input type="text" class="form-control" id="kin_first_name" name="kin_first_name" required />
        </div>

        <div class="mb-3">
          <label for="kin_last_name" class="form-label">Last Name</label>
          <input type="text" class="form-control" id="kin_last_name" name="kin_last_name" required />
        </div>

        <div class="mb-3">
          <label for="relationship" class="form-label">Relationship</label>
          <input type="text" class="form-control" id="relationship" name="relationship" required />
        </div>

        <div class="mb-3">
          <label for="kin_phone_number" class="form-label">Phone Number</label>
          <input type="text" class="form-control" id="kin_phone_number" name="kin_phone_number" required />
        </div>

        <div class="d-flex justify-content-between">
          <button type="button" id="prevStep3" class="btn btn-secondary">Previous</button>
          <button type="submit" id="submitBtn" class="btn btn-primary">Submit</button>
        </div>
      </div>

    </form>
  </div>

  <script>
    $(document).ready(function () {
      // Show step 1 initially
      showStep(1);

      // Helper: Show only one step
      function showStep(step) {
        $('.step-content').hide();
        $('#step' + step).show();
      }

      // Role change: Show password field only for admin and receptionist
      $('#role').change(function () {
        const role = $(this).val();
        if (role === 'admin' || role === 'receptionist') {
          $('#passwordField').show();
          $('#password').attr('required', true);
        } else {
          $('#passwordField').hide();
          $('#password').attr('required', false);
          $('#password').val('');
        }

        // Update Company ID
        const year = new Date().getFullYear().toString().slice(-2);
        const prefix = role === 'admin' ? 'ADM' : role === 'mechanic' ? 'MECH' : 'RP';

        fetch("<?= base_url('user/getLastId') ?>/" + role)
          .then(res => res.json())
          .then(data => {
            const lastId = (parseInt(data.id) + 1).toString().padStart(3, '0');
            $('#company_id').val(prefix + year + lastId);
          })
          .catch(() => {
            $('#company_id').val(prefix + year + '001'); // Fallback
          });
      });

      // Step 1 -> Step 2
      $('#nextStep').click(function () {
        if ($('#multiStepForm')[0].checkValidity()) {
          showStep(2);
        } else {
          $('#multiStepForm')[0].reportValidity();
        }
      });

      // Step 2 -> Step 3
      $('#nextStep2').click(function () {
        if ($('#multiStepForm')[0].checkValidity()) {
          showStep(3);
        } else {
          $('#multiStepForm')[0].reportValidity();
        }
      });

      // Step 2 -> Step 1
      $('#prevStep2').click(function () {
        showStep(1);
      });

      // Step 3 -> Step 2
      $('#prevStep3').click(function () {
        showStep(2);
      });

      // Form submit
      $('#multiStepForm').submit(function (e) {
        e.preventDefault();

        if (!this.checkValidity()) {
          this.reportValidity();
          return;
        }

        const formData = new FormData(this);

        $.ajax({
          url: "<?= base_url('user/final_submit') ?>",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            if (response.success) {
              Swal.fire('Success', 'User successfully added!', 'success').then(() => {
                window.location.reload();
              });
            } else {
              Swal.fire('Error', 'Error saving user. Please try again.', 'error');
            }
          },
          error: function () {
            Swal.fire('Error', 'Server error. Please try again.', 'error');
          }
        });
      });
    });
  </script>

</body>

</html>
