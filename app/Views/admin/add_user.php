<!DOCTYPE html>
<html>

<head>
  <title>Add New User - Multi-Step Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

  <div class="container mt-5">
    <h3>Add New User - Multi-Step Form</h3>

    <form id="multiStepForm" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <h5>Step 1: Company Information</h5>


      <div id="step1">

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
      </div>

      <!-- Step 2 -->
      <div id="step2" style="display: none;">
        <h5>Step 2: Personal Information</h5>
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
      </div>


      <div id="step3" style="display: none;">
        <h5>Step 3: Next of Kin Information</h5>
        <!-- First Name -->
        <div class="mb-3">
          <label for="kin_first_name" class="form-label">First Name</label>
          <input type="text" class="form-control" id="kin_first_name" name="kin_first_name" required>
        </div>

        <!-- Last Name -->
        <div class="mb-3">
          <label for="kin_last_name" class="form-label">Last Name</label>
          <input type="text" class="form-control" id="kin_last_name" name="kin_last_name" required>
        </div>

        <!-- Relationship -->
        <div class="mb-3">
          <label for="relationship" class="form-label">Relationship</label>
          <input type="text" class="form-control" id="relationship" name="relationship" required>
        </div>

        <!-- Phone Number -->
        <div class="mb-3">
          <label for="kin_phone_number" class="form-label">Phone Number</label>
          <input type="text" class="form-control" id="kin_phone_number" name="kin_phone_number" required>
        </div>

        <!-- Navigation Buttons -->
        <div class="d-flex justify-content-between">
          <button type="button" onclick="goBackToStep2()" class="btn btn-secondary">Previous</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>
  </div>

  <script>
   $(document).ready(function() {
  showStep(1); // Initially show step 1

  // Show the appropriate step
  function showStep(step) {
    $(".step-content").addClass('d-none'); // Hide all steps
    $("#step" + step).removeClass('d-none'); // Show the selected step
  }

  // Save step data with AJAX
  function saveStepData(step) {
    const formData = new FormData($('#multiStepForm')[0]); // Serialize form data including files
    formData.append('step', step);

    $.ajax({
      url: "<?= base_url('user/save_step_data/') ?>" + step,
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        if (response.success) {
          showStep(step + 1); // Move to the next step
        } else {
          alert('Error saving step data. Please try again.');
        }
      },
      error: function() {
        alert('Error saving step data. Please try again.');
      }
    });
  }

  // Final submission after completing all steps
  function finalSubmit() {
    const formData = new FormData($('#multiStepForm')[0]); // Serialize all form data

    $.ajax({
      url: "<?= base_url('user/final_submit') ?>",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        if (response.success) {
          alert('User successfully added!');
          window.location.reload(); // Reload the page
        } else {
          alert('Error saving user. Please try again.');
        }
      },
      error: function() {
        alert('Error saving user. Please try again.');
      }
    });
  }

  // Handle role selection and display/hide the password field
  $('#role').change(function() {
    const role = $(this).val();
    const passwordField = $('#passwordField'); // Assuming this is where the password field is.

    if (role === 'admin' || role === 'receptionist') {
      passwordField.show(); // Show password field if Admin or Receptionist
    } else {
      passwordField.hide(); // Hide password field for other roles
    }

    // Update Company ID based on the role
    const year = new Date().getFullYear().toString().slice(-2);
    const prefix = role === 'admin' ? 'ADM' :
                   role === 'mechanic' ? 'MECH' : 'RP';

    fetch("<?= base_url('user/getLastId') ?>/" + role)
      .then(response => response.json())
      .then(data => {
        const lastId = (parseInt(data.id) + 1).toString().padStart(3, '0');
        $('#company_id').val(prefix + year + lastId); // Set the Company ID
      })
      .catch(error => console.error('Error:', error));
  });

  // Handle the "Next Step" button click
  $('#nextStep').click(function() {
    saveStepData(1); // Save Step 1 data
  });

  // Handle the final submission button on Step 3
  $('#submitBtn').click(function() {
    finalSubmit();
  });

  // Handle going back to previous steps (e.g., from Step 2 to Step 1)
  $('#prevStep').click(function() {
    showStep(1); // Go back to Step 1
  });

  $('#prevStep2').click(function() {
    showStep(2); // Go back to Step 2
  });
});

  </script>

</body>

</html>