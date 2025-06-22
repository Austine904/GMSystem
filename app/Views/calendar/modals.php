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


<!-- Multi-Step Add Event Modal -->
<div id="addEventModal" class="modal fade" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addEventForm">
          <!-- Step 1: Basic Info -->
          <div class="form-step" data-step="1">
            <div class="mb-3">
              <label for="eventTitle" class="form-label">Event Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="eventTitle" name="title" required>
            </div>
            <div class="mb-3">
              <label for="eventType" class="form-label">Event Type</label>
              <select class="form-select select2" id="eventType" name="event_type" required>
                <option value="">-- Select Type --</option>
                <option value="job_pickup">Job Pickup</option>
                <option value="appointment">Appointment</option>
                <option value="meeting">Meeting</option>
                <option value="holiday">Holiday</option>
                <option value="leave">Leave</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="eventColor" class="form-label">Event Color</label>
              <input type="color" class="form-control form-control-color" id="eventColor" name="color" value="#007bff">
            </div>
            <div class="mb-3">
              <label for="eventDescription" class="form-label">Description</label>
              <textarea class="form-control" id="eventDescription" name="description" rows="3"></textarea>
            </div>
          </div>

          <!-- Step 2: Scheduling -->
          <div class="form-step d-none" data-step="2">
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="eventStart" class="form-label">Start Time <span class="text-danger">*</span></label>
                <input type="datetime-local" class="form-control" id="eventStart" name="start_time" required>
              </div>
              <div class="col-md-6">
                <label for="eventEnd" class="form-label">End Time</label>
                <input type="datetime-local" class="form-control" id="eventEnd" name="end_time">
              </div>
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="eventAllDay" name="all_day">
              <label class="form-check-label" for="eventAllDay">All Day Event</label>
            </div>
          </div>

          <!-- Step 3: Related Info -->
          <div class="form-step d-none" data-step="3">
            <div id="dynamicFieldsContainer"></div>
            <div class="mb-3">
              <label for="notifyUsers" class="form-label">Notify Users</label>
              <select id="notifyUsers" class="form-select select2" name="notify_users[]" multiple>
                <option value="1">Admin</option>
                <option value="2">Mechanic</option>
                <option value="3">Receptionist</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="priority" class="form-label">Priority</label>
              <select class="form-select" id="priority" name="priority">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
              </select>
            </div>
          </div>

          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" id="prevStepBtn" disabled>Back</button>
            <button type="button" class="btn btn-primary" id="nextStepBtn">Next</button>
            <button type="submit" class="btn btn-success d-none" id="submitEventBtn">Save Event</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1100">
  <div id="calendarToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        Event saved successfully!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;

    const steps = document.querySelectorAll('.form-step');
    const nextBtn = document.getElementById('nextStepBtn');
    const prevBtn = document.getElementById('prevStepBtn');
    const submitBtn = document.getElementById('submitEventBtn');
    const form = document.getElementById('addEventForm');
    const typeSelect = document.getElementById('eventType');
    const dynamicContainer = document.getElementById('dynamicFieldsContainer');

    function updateStepDisplay() {
      steps.forEach(step => step.classList.add('d-none'));
      document.querySelector(`.form-step[data-step="${currentStep}"]`).classList.remove('d-none');
      prevBtn.disabled = currentStep === 1;
      nextBtn.classList.toggle('d-none', currentStep === steps.length);
      submitBtn.classList.toggle('d-none', currentStep !== steps.length);
    }

    function generateDynamicFields(type) {
      let html = '';
      if (type === 'job_pickup') {
        html += '<div class="mb-3"><label>Job ID</label><input type="text" name="job_id" class="form-control"></div>';
        html += '<div class="mb-3"><label>Vehicle</label><input type="text" name="vehicle" class="form-control"></div>';
      } else if (type === 'meeting') {
        html += '<div class="mb-3"><label>Location</label><input type="text" name="location" class="form-control"></div>';
        html += '<div class="mb-3"><label>Participants</label><input type="text" name="participants" class="form-control"></div>';
      } else if (type === 'leave') {
        html += '<div class="mb-3"><label>Staff Name</label><input type="text" name="staff" class="form-control"></div>';
        html += '<div class="mb-3"><label>Leave Type</label><input type="text" name="leave_type" class="form-control"></div>';
      }
      dynamicContainer.innerHTML = html;
    }

    typeSelect.addEventListener('change', function() {
      generateDynamicFields(this.value);
    });

    nextBtn.addEventListener('click', function() {
      if (currentStep < steps.length) {
        currentStep++;
        updateStepDisplay();
      }
    });

    prevBtn.addEventListener('click', function() {
      if (currentStep > 1) {
        currentStep--;
        updateStepDisplay();
      }
    });

    $(".select2").select2({
      dropdownParent: $("#addEventModal")
    });

    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(form);

      fetch(`${BASE_URL}admin/calendar/addEvent`, {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(result => {
          if (result.success || result.message?.includes("success")) {
            Swal.fire('Success', 'Event added successfully!', 'success');
            bootstrap.Modal.getInstance(document.getElementById('addEventModal')).hide();
            form.reset();
            currentStep = 1;
            updateStepDisplay();
          } else {
            Swal.fire('Error', result.message || 'Something went wrong.', 'error');
          }
        })
        .catch(error => {
          Swal.fire('Error', error.message || 'Server error occurred.', 'error');
        });
    });

    updateStepDisplay();
  });
</script>