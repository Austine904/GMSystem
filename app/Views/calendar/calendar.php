<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>



<div class="container mt-5">
    <h3>Service Calendar</h3>

    <div class="calendar-card">
        <div id="calendar"></div>
    </div>
</div>

<!-- Re-using actionModal for Event Details -->
<div id="actionModal" class="modal fade" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actionModalLabel">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalContent">
                    <!-- Event details will be loaded here -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item"><span class="info-label">Event Type:</span> <span class="info-value" id="event_type"></span></div>
                            <div class="info-item"><span class="info-label">Title:</span> <span class="info-value" id="event_title"></span></div>
                            <div class="info-item"><span class="info-label">Start Time:</span> <span class="info-value" id="event_start"></span></div>
                            <div class="info-item"><span class="info-label">End Time:</span> <span class="info-value" id="event_end"></span></div>
                            <div class="info-item"><span class="info-label">Status:</span> <span class="info-value" id="event_status"></span></div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item"><span class="info-label">Job No:</span> <span class="info-value" id="event_job_no"></span></div>
                            <div class="info-item"><span class="info-label">Vehicle:</span> <span class="info-value" id="event_vehicle"></span></div>
                            <div class="info-item"><span class="info-label">Customer:</span> <span class="info-value" id="event_customer"></span></div>
                            <div class="info-item"><span class="info-label">Mechanic:</span> <span class="info-value" id="event_mechanic"></span></div>
                            <div class="info-item"><span class="info-label">Description:</span> <span class="info-value" id="event_description"></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>