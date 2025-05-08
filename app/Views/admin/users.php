<?php echo $this->extend('layouts/main'); ?>

<?php echo $this->section('content'); ?>

<div class="container mt-6">
    <h3 class="mb-5">User Management</h3>
    <div class="d-flex justify-content-between mb-3">
        <a href="<?= base_url('admin/users/add') ?>" class="btn btn-primary">Add New User</a>

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
                    <th>#</th>
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
                        <td>
                            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#userDetailsModal" onclick="loadUserDetails(<?= $user['id'] ?>)">
                                <?= esc($user['name']) ?>
                            </button>
                        </td>
                        <td><?= esc($user['phone']) ?></td>
                        <td><?= esc($user['role']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>
</div>

<!-- User Details Modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailsModalLabel">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="user-details-content">
                <!-- This will be dynamically populated with user details -->
            </div>
            <div class="modal-footer">
                <!-- Action buttons -->
                <a href="#" id="edit-user-btn" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="#" id="delete-user-btn" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
                    <i class="bi bi-trash"></i> Delete
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
            // Display user details in the modal
            document.getElementById('user-details-content').innerHTML = `
                <p><strong>Name:</strong> ${data.name}</p>
                <p><strong>Phone:</strong> ${data.phone}</p>
                <p><strong>Role:</strong> ${data.role}</p>
            `;

            // Update action buttons with the correct URLs
            document.getElementById('edit-user-btn').href = `<?= base_url('admin/users/edit/') ?>/${userId}`;
            document.getElementById('delete-user-btn').href = `<?= base_url('admin/users/delete/') ?>/${userId}`;

            // Show the modal after content is loaded
            $('#userDetailsModal').modal('show');
        })
        .catch(error => console.error('Error loading user details:', error));
}


    const searchInput = document.getElementById('search');

    // Function to load user list
    function loadUsers(url) {
        fetch(url, {
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        })
        .then(response => response.text())
        .then(data => {
            // Only replace the <tbody> part of the table
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
</script>

<?php echo $this->endSection(); ?>
