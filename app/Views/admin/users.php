<?php echo $this->extend('layouts/main'); ?>

<?php echo $this->section('content'); ?>

<div class="container mt-6">
    <h3 class="mb-5">User Management</h3>
    <div class="d-flex justify-content-between mb-3">
        <button onclick="openModal('<?= base_url('admin/users/add') ?>')" class="btn btn-outline-primary d-flex align-items-center gap-2">
            <i class="bi bi-person-plus"></i> Add User
        </button>

        <div class="d-flex gap-2">
            <input type="text" class="form-control" id="search" placeholder="Search by name or phone">
            <select class="form-select" id="role-filter">
                <option value="">All Roles</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('admin/users/bulk_action') ?>">
        <button type="submit" class="btn btn-danger mb-2" onclick="return confirm('Are you sure you want to delete selected users?')">Delete Selected</button>

        <table class="table table-striped table-bordered mt-3">
            <thead class="table-light">
                <tr>
                    <th><input type="checkbox" id="select_all"></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody id="user-list">
                <?php foreach ($users as $user): ?>

                    <tr>
                        <td><input type="checkbox" name="users[]" value="<?= $user['id'] ?>"></td>
                        <td><?= esc($user['id']) ?></td>
                        <td><?= esc($user['first_name'] . ' ' . $user['last_name']) ?></td>
                        <td><?= esc($user['phone_number']) ?></td>
                        <td><?= esc($user['role']) ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm view-user" data-id="<?= $user['id'] ?>">
                                <i class="bi bi-eye"></i> View
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>
</div>

<!-- Add User Details Modal -->
<div id="actionModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalContent">Loading...</div>
            </div>
        </div>
    </div>
</div>

<!-- View User Details Modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="userDetailsModalLabel">
                    <i class="bi bi-person-circle me-2"></i> Admin User Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <!-- Main Content Card (Additional Details) -->
                    <div class="col-md-9">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <i class="bi bi-info-circle me-1"></i> Additional Information
                            </div>
                            <div class="card-body" id="admin-additional-details">
                                <!-- Suggestions for additional details:
                                    - Login History
                                    - Role-specific Privileges
                                    - Last Activity
                                    - Department Information
                                    - Projects Managed
                                    - Recent Activities 
                                    - Performance Metrics
                                -->
                                <p><strong>Last Login:</strong> <span id="last-login"></span></p>
                                <p><strong>Department:</strong> <span id="department"></span></p>
                                <p><strong>Role Privileges:</strong> <span id="role-privileges"></span></p>
                                <p><strong>Projects Managed:</strong> <span id="projects-managed"></span></p>
                                <p><strong>Recent Activities:</strong> <span id="recent-activities"></span></p>
                                <p><strong>Performance Metrics:</strong> <span id="performance-metrics"></span></p>

                            </div>
                        </div>
                    </div>

                    <!-- Right Side Card (Basic Details) -->
                    <div class="col-md-3">
                        <div class="card shadow-sm">
                            <img id="user-photo" src="" class="card-img-top" alt="User Photo">
                            <div class="card-body">
                                <h5 class="card-title" id="user-fullname"></h5>
                                <p><strong>Company ID:</strong> <span id="company_id"></span></p>
                                <p><strong>Employment Date:</strong> <span id="date_of employment"></span></p>
                                <p><strong>Year of Birth:</strong> <span id="dob"></span></p>
                                <p><strong>National ID:</strong> <span id="national_id"></span></p>
                                <p><strong>Next of Kin:</strong> <span id="kin_first_name"></span></p>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('select_all').onclick = function() {
        let checkboxes = document.querySelectorAll('input[name="users[]"]');
        checkboxes.forEach((checkbox) => checkbox.checked = this.checked);
    };

    function loadUserDetails(userId) {
        fetch(`<?= base_url('admin/users/details/') ?>/${userId}`)
            .then(response => response.json())
            .then(data => {
                // Populate Basic Details (Right Card)
                document.getElementById('user-photo').src = data.photo ? data.photo : 'default-photo.jpg';
                document.getElementById('user-fullname').innerText = data.name;
                document.getElementById('user-company-id').innerText = data.company_id;
                document.getElementById('user-employment-date').innerText = data.employment_date;
                document.getElementById('user-yob').innerText = data.year_of_birth;
                document.getElementById('user-national-id').innerText = data.national_id;
                document.getElementById('user-next-of-kin').innerText = data.next_of_kin;

                // Populate Additional Details (Main Card)
                document.getElementById('last-login').innerText = data.last_login;
                document.getElementById('department').innerText = data.department;
                document.getElementById('role-privileges').innerText = data.role_privileges;
                document.getElementById('projects-managed').innerText = data.projects_managed;
                document.getElementById('recent-activities').innerText = data.recent_activities;
                document.getElementById('performance-metrics').innerText = data.performance_metrics;

                // Show the modal
                $('#userDetailsModal').modal('show');
            })
            .catch(error => {
                console.error('Error loading user details:', error);
                alert('Failed to load user details. Please try again.');
            });
    }

    const searchInput = document.getElementById('search');

    // Function to load user list
    function loadUsers(url) {
        fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('user-list').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    }

    searchInput.addEventListener('input', () => {
        const query = searchInput.value;
        loadUsers(`<?= base_url('admin/users') ?>?search=${query}`);
    });

    // Pagination handling
    document.addEventListener('click', function(e) {
        if (e.target.tagName === 'A' && e.target.closest('#pagination-links')) {
            e.preventDefault();
            loadUsers(e.target.href);
        }
    });

    function openModal(url) {
        const modal = new bootstrap.Modal(document.getElementById('actionModal'));
        modal.show();

        fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('modalContent').innerHTML = data;
            })
            .catch(error => {
                document.getElementById('modalContent').innerHTML = "Error loading content.";
                console.error('Error:', error);
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const viewButtons = document.querySelectorAll('.view-user');

        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                loadUserDetails(userId);
            });
        });
    });


    function loadUserDetails(userId) {
        fetch(`<?= base_url('admin/users/details/') ?>/${userId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Open the modal
                const modal = new bootstrap.Modal(document.getElementById('userDetailsModal'));
                modal.show();


            })
            .catch(error => {
                console.error('Error fetching user details:', error);
                alert('Failed to load user details. Please try again.');
            });
    }
</script>

<?php echo $this->endSection(); ?>