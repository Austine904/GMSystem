<!DOCTYPE html>
<html>

<head>
  <title>Add New User - Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <div class="container mt-5">
    <h3>Add New User</h3>

    <!-- Multi-step form (Step 1) -->
    <form action="<?= site_url('user/step1') ?>" method="POST" enctype="multipart/form-data">
      <?= csrf_field() ?>

      <!-- User Image -->
      <div class="mb-3">
        <label for="profile_picture" class="form-label">Profile Picture</label>
        <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
        <small class="form-text text-muted">Upload a profile picture (max 2MB, image files only).</small>
        <?php if (isset($errors['profile_picture'])): ?>
          <div class="text-danger"><?= $errors['profile_picture'] ?></div>
        <?php endif; ?>
      </div>

      <!-- Company Info -->
      <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-control" id="role" name="role">
          <option value="Admin">Admin</option>
          <option value="Mechanic">Mechanic</option>
          <option value="Receptionist">Receptionist</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="company_id" class="form-label">Company ID</label>
        <input type="text" class="form-control" id="company_id" name="company_id" readonly>
      </div>

      <div class="mb-3">
        <label for="date_of_employment" class="form-label">Date of Employment</label>
        <input type="text" class="form-control" id="date_of_employment" name="date_of_employment" value="<?= date('Y-m-d') ?>" readonly>
      </div>

      <!-- Submit Button (Step 1) -->
      <button type="submit" class="btn btn-primary">Next</button>
    </form>
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


</body>

</html>