<?php
// Ensure $sublet, $job_cards, and $sublet_providers are defined to avoid errors
$sublet = $sublet ?? null;
$job_cards = $job_cards ?? [];
$sublet_providers = $sublet_providers ?? [];

// Determine if we are editing an existing sublet
$is_edit = (bool)$sublet;

// Pre-fill form values if in edit mode
$id = $is_edit ? esc($sublet['id']) : '';
$job_card_id = $is_edit ? esc($sublet['job_card_id']) : '';
$sublet_provider_id = $is_edit ? esc($sublet['sublet_provider_id']) : '';
$description = $is_edit ? esc($sublet['description']) : '';
$cost = $is_edit ? esc($sublet['cost']) : '';
$status = $is_edit ? esc($sublet['status']) : 'Pending';
$date_sent = $is_edit ? esc($sublet['date_sent']) : date('Y-m-d'); // Default to today
$date_returned = $is_edit && $sublet['date_returned'] ? esc($sublet['date_returned']) : '';
$notes = $is_edit ? esc($sublet['notes']) : '';
?>

<form id="subletForm" class="p-3">
    <?= csrf_field() ?>
    <?php if ($is_edit): ?>
        <input type="hidden" name="id" value="<?= $id ?>">
    <?php endif; ?>

    <div class="mb-3">
        <label for="job_card_id" class="form-label">Job Card <span class="text-danger">*</span></label>
        <select class="form-select" id="job_card_id" name="job_card_id" required>
            <option value="">Select Job Card</option>
            <?php foreach ($job_cards as $job_card): ?>
                <option value="<?= esc($job_card['id']) ?>"
                    data-vehicle-reg="<?= esc($job_card['registration_number'] ?? 'N/A') ?>"
                    <?= ($job_card['id'] == $job_card_id) ? 'selected' : '' ?>>
                    <?= esc($job_card['job_no'] ?? 'N/A') ?> (<?= esc($job_card['registration_number'] ?? 'N/A') ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <div class="invalid-feedback">Please select a Job Card.</div>
    </div>

    <div class="mb-3">
        <label for="sublet_provider_id" class="form-label">Sublet Provider <span class="text-danger">*</span></label>
        <select class="form-select" id="sublet_provider_id" name="sublet_provider_id" required>
            <option value="">Select Provider</option>
            <?php foreach ($sublet_providers as $provider): ?>
                <option value="<?= esc($provider['id']) ?>" <?= ($provider['id'] == $sublet_provider_id) ? 'selected' : '' ?>>
                    <?= esc($provider['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div class="invalid-feedback">Please select a Sublet Provider.</div>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description of Sublet Work <span class="text-danger">*</span></label>
        <textarea class="form-control" id="description" name="description" rows="3" required><?= $description ?></textarea>
        <div class="invalid-feedback">Description is required (min 5 characters).</div>
    </div>

    <div class="mb-3">
        <label for="cost" class="form-label">Cost <span class="text-danger">*</span></label>
        <input type="number" step="0.01" class="form-control" id="cost" name="cost" value="<?= $cost ?>" required min="0">
        <div class="invalid-feedback">Cost is required and must be a non-negative number.</div>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
        <select class="form-select" id="status" name="status" required>
            <option value="Pending" <?= ($status == 'Pending') ? 'selected' : '' ?>>Pending</option>
            <option value="In Progress" <?= ($status == 'In Progress') ? 'selected' : '' ?>>In Progress</option>
            <option value="Completed" <?= ($status == 'Completed') ? 'selected' : '' ?>>Completed</option>
            <option value="Invoiced" <?= ($status == 'Invoiced') ? 'selected' : '' ?>>Invoiced</option>
            <option value="Paid" <?= ($status == 'Paid') ? 'selected' : '' ?>>Paid</option>
            <option value="Cancelled" <?= ($status == 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
        </select>
        <div class="invalid-feedback">Please select a status.</div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="date_sent" class="form-label">Date Sent <span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="date_sent" name="date_sent" value="<?= $date_sent ?>" required>
            <div class="invalid-feedback">Date Sent is required.</div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="date_returned" class="form-label">Date Returned</label>
            <input type="date" class="form-control" id="date_returned" name="date_returned" value="<?= $date_returned ?>">
            <div class="invalid-feedback">Date Returned must be after Date Sent.</div>
        </div>
    </div>

    <div class="mb-3">
        <label for="notes" class="form-label">Notes (Optional)</label>
        <textarea class="form-control" id="notes" name="notes" rows="2"><?= $notes ?></textarea>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">
            <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
            <span class="button-text"><?= $is_edit ? 'Update Sublet' : 'Add Sublet' ?></span>
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subletForm = document.getElementById('subletForm');
        const submitBtn = subletForm.querySelector('button[type="submit"]');

        subletForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Clear previous validation messages
            subletForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            subletForm.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

            // Basic client-side validation
            let isValid = true;
            subletForm.querySelectorAll('[required]').forEach(input => {
                if (!input.value) {
                    input.classList.add('is-invalid');
                    input.nextElementSibling.textContent = 'This field is required.';
                    isValid = false;
                }
            });

            // Specific validation for cost
            const costInput = document.getElementById('cost');
            if (costInput.value < 0) {
                costInput.classList.add('is-invalid');
                costInput.nextElementSibling.textContent = 'Cost cannot be negative.';
                isValid = false;
            }

            // Specific validation for date_returned vs date_sent
            const dateSentInput = document.getElementById('date_sent');
            const dateReturnedInput = document.getElementById('date_returned');
            if (dateReturnedInput.value && dateSentInput.value && new Date(dateReturnedInput.value) < new Date(dateSentInput.value)) {
                dateReturnedInput.classList.add('is-invalid');
                dateReturnedInput.nextElementSibling.textContent = 'Date Returned cannot be earlier than Date Sent.';
                isValid = false;
            }

            if (!isValid) {
                return; // Stop submission if client-side validation fails
            }

            // Show loading spinner
            submitBtn.disabled = true;
            submitBtn.querySelector('.spinner-border').classList.remove('d-none');
            submitBtn.querySelector('.button-text').classList.add('invisible');

            const formData = new FormData(subletForm);
            const url = '<?= base_url('admin/sublets/save') ?>';

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData, // FormData handles multipart/form-data for file uploads and text
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Important for CodeIgniter's isAJAX()
                    }
                });

                const result = await response.json();

                if (response.ok && result.status === 'success') {
                    Swal.fire('Success!', result.message, 'success');
                    // Assuming 'actionModal' is the parent modal
                    const modalInstance = bootstrap.Modal.getInstance(document.getElementById('actionModal'));
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                    // Trigger a custom event to notify the parent page to reload DataTables
                    document.dispatchEvent(new CustomEvent('subletSaved'));
                } else {
                    let errorMessage = result.message || 'Failed to save sublet.';
                    if (result.errors) {
                        errorMessage = 'Validation Errors:';
                        for (const field in result.errors) {
                            displayFeedback(field, result.errors[field]);
                        }
                        Swal.fire({
                            title: 'Validation Failed!',
                            html: "Please correct the highlighted errors.",
                            icon: 'error'
                        });
                    } else {
                         Swal.fire('Error!', errorMessage, 'error');
                    }
                }
            } catch (error) {
                console.error('Error saving sublet:', error);
                Swal.fire('Error!', 'An unexpected error occurred: ' + error.message, 'error');
            } finally {
                // Hide loading spinner
                submitBtn.disabled = false;
                submitBtn.querySelector('.spinner-border').classList.add('d-none');
                submitBtn.querySelector('.button-text').classList.remove('invisible');
            }
        });

        // Helper to display backend validation feedback
        function displayFeedback(field, message) {
            const input = document.getElementById(field);
            if (input) {
                input.classList.add('is-invalid');
                let feedbackDiv = input.nextElementSibling;
                if (feedbackDiv && feedbackDiv.classList.contains('invalid-feedback')) {
                    feedbackDiv.textContent = message;
                } else {
                    // Create if not exists (though it should from the HTML)
                    feedbackDiv = document.createElement('div');
                    feedbackDiv.classList.add('invalid-feedback');
                    feedbackDiv.textContent = message;
                    input.parentNode.insertBefore(feedbackDiv, input.nextSibling);
                }
            }
        }
    });
</script>
