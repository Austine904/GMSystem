<table class="table table-striped table-bordered mt-3">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Roleeeee</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= esc($user['id']) ?></td>
                <td><?= esc($user['name']) ?></td>
                <td><?= esc($user['phone']) ?></td>
                <td><?= esc($user['role']) ?></td>
                <td>
                    <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Pagination Links -->
<div id="pagination-links">
    <?= $pager->links('default', 'bootstrap_pagination') ?>
</div>
