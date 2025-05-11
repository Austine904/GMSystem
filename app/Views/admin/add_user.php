<!DOCTYPE html>
<html>

<head>
  <title>Add New User - Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

  <div class="container mt-5">
    <h3>Add New User</h3>

    <!-- Multi-step form (Step 1) -->
    <form id="step1Form" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <!-- User Image -->
      <div class="mb-3">
        <label for="profile_picture" class="form-label">Profile Picture</label>
        <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
        <small class="form-text text-muted">Upload a profile picture (max 2MB, image files only).</small>
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
        <label for="date_of_employment" class="form-label">Date of Employment</label>
        <input type="text" class="form-control" id="date_of_employment" name="date_of_employment" value="<?= date('Y-m-d') ?>" readonly>
      </div>

      <!-- Submit Button (Step 1) -->
      <button type="submit" class="btn btn-primary">Next</button>
    </form>
  </div>

  <!-- Modal for Step 2 -->
  <div id="multiStepModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New User - Step 2</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="modalContent">
          <!-- Content for Step 2 will be injected here -->
        </div>
      </div>
    </div>
  </div>

  <script>
    // Handle role change for Company ID generation
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

    // Handle form submission with AJAX
    // Handle form submission with AJAX
    $('#step1Form').submit(function(e) {
      e.preventDefault();

      var formData = new FormData(this); // Use FormData to handle file uploads

      $.ajax({
        url: "<?= base_url('user/step1') ?>",
        type: "POST",
        data: formData,
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Prevent jQuery from setting content type
        success: function(response) {
          // if (response.success) {
            // Load Step 2 content into the modal
            $.ajax({
              url: "<?= base_url('user/add_step2') ?>",
              type: "GET",
              success: function(step2) {
                $('#modalContent').html(step2); // Correct ID now
                $('#multiStepModal').modal('show'); // Show the modal
              },
              error: function(xhr, status, error) {
                console.error("Error loading Step 2: ", error);
              }
            });
          // } else {
          //   alert('Something went wrong!');
          // }
        },
        error: function(xhr, status, error) {
          console.error("AJAX Error: ", error);
          alert('Failed to submit Step 1.');
        }
      });
    });
  </script>

</body>

</html>