<?php
// Ensure $sublet is defined and not null
$sublet = $sublet ?? [];

// Helper function for safe output
$safe = function($value) {
    return esc($value) ?? 'N/A';
};

// Function to get status badge class
$getStatusBadgeClass = function($status) {
    switch ($status) {
        case 'Pending': return 'status-badge-pending';
        case 'In Progress': return 'status-badge-in-progress';
        case 'Completed': return 'status-badge-completed';
        case 'Invoiced': return 'status-badge-invoiced';
        case 'Paid': return 'status-badge-paid';
        case 'Cancelled': return 'status-badge-cancelled';
        default: return 'bg-secondary text-white'; // Default Bootstrap grey
    }
};
?>

<div class="row">
    <div class="col-12">
        <div class="info-item"><span class="info-label">Sublet ID:</span> <span class="info-value"><?= $safe($sublet['id']) ?></span></div>
        <div class="info-item"><span class="info-label">Job No:</span> <span class="info-value"><?= $safe($sublet['job_no']) ?></span></div>
        <div class="info-item"><span class="info-label">Vehicle Reg:</span> <span class="info-value"><?= $safe($sublet['registration_number']) ?></span></div>
        <div class="info-item"><span class="info-label">Provider:</span> <span class="info-value"><?= $safe($sublet['provider_name']) ?></span></div>
        <div class="info-item"><span class="info-label">Cost:</span> <span class="info-value">KES <?= number_format($sublet['cost'] ?? 0, 2) ?></span></div>
        <div class="info-item">
            <span class="info-label">Status:</span>
            <span class="status-badge <?= $getStatusBadgeClass($sublet['status']) ?>"><?= $safe($sublet['status']) ?></span>
        </div>
        <div class="info-item"><span class="info-label">Date Sent:</span> <span class="info-value"><?= $safe($sublet['date_sent']) ?></span></div>
        <div class="info-item"><span class="info-label">Date Returned:</span> <span class="info-value"><?= $safe($sublet['date_returned']) ?></span></div>
        <div class="info-item"><span class="info-label">Description:</span> <span class="info-value"><?= nl2br($safe($sublet['description'])) ?></span></div>
        <div class="info-item"><span class="info-label">Notes:</span> <span class="info-value"><?= nl2br($safe($sublet['notes'])) ?></span></div>
        <div class="info-item"><span class="info-label">Created At:</span> <span class="info-value"><?= $safe($sublet['created_at']) ?></span></div>
        <div class="info-item"><span class="info-label">Last Updated:</span> <span class="info-value"><?= $safe($sublet['updated_at']) ?></span></div>
    </div>
</div>
