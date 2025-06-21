<!-- Re-using actionModal for Event Details -->
<div id="actionModal" class="modal fade" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title" id="actionModalLabel">
                    <i class="bi bi-info-circle-fill me-2"></i> Event Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">

                <!-- Section: Event Info -->
                <div class="section-box mb-3">
                    <h6 class="section-title">🗓️ Event Information</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div><strong>Event Type:</strong> <span id="event_type" class="text-muted ms-1"></span></div>
                            <div><strong>Title:</strong> <span id="event_title" class="text-muted ms-1"></span></div>
                        </div>
                        <div class="col-md-6">
                            <div><strong>Start Time:</strong> <span id="event_start" class="text-muted ms-1"></span></div>
                            <div><strong>End Time:</strong> <span id="event_end" class="text-muted ms-1"></span></div>
                            <div><strong>Status:</strong> <span id="event_status" class="text-muted ms-1"></span></div>
                        </div>
                    </div>
                </div>

                <!-- Section: Job Info -->
                <div class="section-box mb-3">
                    <h6 class="section-title">🔧 Job Information</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div><strong>Job No:</strong> <span id="event_job_no" class="text-muted ms-1"></span></div>
                            <div><strong>Vehicle:</strong> <span id="event_vehicle" class="text-muted ms-1"></span></div>
                        </div>
                        <div class="col-md-6">
                            <div><strong>Mechanic:</strong> <span id="event_mechanic" class="text-muted ms-1"></span></div>
                        </div>
                    </div>
                </div>

                <!-- Section: Customer -->
                <div class="section-box mb-3">
                    <h6 class="section-title">👤 Customer</h6>
                    <div><strong>Name:</strong> <span id="event_customer" class="text-muted ms-1"></span></div>
                </div>

                <!-- Section: Description -->
                <div class="section-box">
                    <h6 class="section-title">📝 Description</h6>
                    <div><span id="event_description" class="text-muted"></span></div>
                </div>

            </div>

            <div class="modal-footer bg-light rounded-bottom-4 px-4 py-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>