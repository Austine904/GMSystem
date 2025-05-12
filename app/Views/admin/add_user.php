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


       <div id="step1">
                    <h5>Step 1: Company Information</h5>
                    <form id="formStep1" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="userImage" class="form-label">User Image</label>
                            <input class="form-control" type="file" id="userImage" name="user_image" accept="image/*">
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

                        <div class="mb-3">
                            <label for="company_id" class="form-label">Company ID</label>
                            <input type="text" class="form-control" id="company_id" name="company_id" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="employment_date" class="form-label">Date of Employment</label>
                            <input type="text" class="form-control" id="employment_date" name="employment_date" readonly value="<?= date('Y-m-d') ?>">
                        </div>

                        <div class="mb-3" id="passwordDiv" style="display: none;">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </form>
                </div>
                
                <!-- Step 2 -->
                <div id="step2" style="display: none;">
                    <h5>Step 2: Personal Information</h5>
                    <form id="formStep2">
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
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </form>
                </div>

                <!-- Step 3 -->
                <div id="step3" style="display: none;">
                    <h5>Step 3: Next of Kin Information</h5>
                    <form id="formStep3">
                        <div class="mb-3">
                            <label for="kin_first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="kin_first_name" name="kin_first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="kin_last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="kin_last_name" name="kin_last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="relationship" class="form-label">Relationship</label>
                            <input type="text" class="form-control" id="relationship" name="relationship" required>
                        </div>
                        <div class="mb-3">
                            <label for="kin_phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="kin_phone_number" name="kin_phone_number" required>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="prevBtn" class="btn btn-secondary" style="display: none;">Previous</button>
                <button type="button" id="nextBtn" class="btn btn-primary">Next</button>
            </div>
        </div>

    </form>
  </div>

  <script>
    $(document).ready(function() {
      showStep(1);

      function showStep(step) {
        $(".step-content").addClass('d-none');
        $("#step" + step).removeClass('d-none');
      }

      function saveStepData(step) {
        const formData = $('#multiStepForm').serialize();
        $.post("<?= base_url('user/save_step_data/') ?>" + step, formData, function(response) {
          if (response.success) {
            showStep(step + 1);
          } else {
            alert('Error saving step data. Please try again.');
          }
        });
      }

      function finalSubmit() {
        $.post("<?= base_url('user/final_submit') ?>", {}, function(response) {
          if (response.success) {
            alert('User successfully added!');
            window.location.reload();
          } else {
            alert('Error saving user. Please try again.');
          }
        });
      }
      // Generate Company ID based on Role
      $('#role').on('change', function() {
        const role = $(this).val();
        const year = new Date().getFullYear().toString().slice(-2);
        const prefix = role === 'admin' ? 'ADM' : role === 'mechanic' ? 'MECH' : 'REC';
        
        $.get("<?= base_url('user/getLastId') ?>/" + role, function(data) {
          const lastId = (parseInt(data.last_id) + 1).toString().padStart(3, '0');
          $('#company_id').val(prefix + year + lastId);
        });
      });
    //   $('#role').on('change', function() {
    //     const role = $(this).val().toUpperCase();
    //     const year = new Date().getFullYear();
    //     const uniqueId = Math.floor(1000 + Math.random() * 9000);
    //     $('#company_id').val(`${role}-${year}-${uniqueId}`);
    //   });
    });
  </script>

</body>

</html>