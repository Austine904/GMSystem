<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css" rel="stylesheet" />

<style>
    /* Consistent theme variables from main layout */
    :root {
        --primary-color: #007bff;
        --primary-hover-color: #0056b3;
        --text-dark: #343a40;
        --bg-light: #f8f9fa;
        --card-bg: #ffffff;
        --shadow-light: rgba(0, 0, 0, 0.1);
        --shadow-medium: rgba(0, 0, 0, 0.15);
        --success-color: #28a745;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
        --info-color: #17a2b8;
    }

    body {
        font-family: 'Inter', sans-serif;
        color: var(--text-dark);
    }

    .container.mt-5 {
        margin-top: 3rem !important;
    }

    h3 {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 2rem !important;
    }

    /* Card styling for the calendar container */
    .calendar-card {
        background-color: var(--card-bg);
        border-radius: 15px;
        box-shadow: 0 10px 30px var(--shadow-medium);
        padding: 2rem;
        position: relative; /* Needed for responsive FullCalendar */
    }

    /* FullCalendar specific styling */
    .fc { /* FullCalendar container */
        font-family: 'Inter', sans-serif;
        max-width: 100%; /* Ensure it doesn't overflow */
    }

    .fc .fc-toolbar-title {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 1.5rem; /* Larger title for calendar header */
    }

    .fc .fc-button {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
        padding: 0.5rem 1rem; /* Adjust button padding */
    }

    .fc .fc-button:hover {
        background-color: var(--primary-hover-color);
        border-color: var(--primary-hover-color);
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0, 123, 255, 0.2);
    }

    .fc .fc-button-primary:not(:disabled).fc-button-active {
        background-color: var(--primary-hover-color);
        border-color: var(--primary-hover-color);
    }

    .fc-event {
        border-radius: 5px;
        font-size: 0.85rem;
        padding: 2px 5px;
        margin-bottom: 2px;
        cursor: pointer; /* Indicate events are clickable */
    }

    .fc-event-title {
        font-weight: 500;
    }

    .fc-daygrid-event {
        white-space: normal; /* Allow event text to wrap */
    }

    .fc-daygrid-day-number {
        color: var(--text-dark);
        font-weight: 500;
    }

    /* Specific event colors (optional, can be passed from backend) */
    .fc-event[data-status="In Progress"] { background-color: var(--info-color); border-color: var(--info-color); }
    .fc-event[data-status="Completed"] { background-color: var(--success-color); border-color: var(--success-color); }
    .fc-event[data-status="Awaiting Parts"] { background-color: var(--warning-color); border-color: var(--warning-color); }
    .fc-event[data-status="Cancelled"] { background-color: var(--danger-color); border-color: var(--danger-color); }

    /* Modal Styling for Event Details (reusing actionModal) */
    #actionModal .modal-header {
        background: linear-gradient(90deg, var(--primary-color), var(--primary-hover-color)) !important;
        color: white !important;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    #actionModal .modal-header .modal-title {
        color: white !important;
    }
    #actionModal .modal-header .btn-close {
        filter: invert(1);
    }
    #actionModal .info-item {
        margin-bottom: 0.75rem;
        text-align: left;
    }
    #actionModal .info-label {
        font-weight: 600;
        color: var(--text-dark);
        display: block;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }
    #actionModal .info-value {
        color: #555;
        font-size: 1rem;
    }
</style>

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

<!-- FullCalendar JS - CHANGED TO index.global.min.js -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<!-- SweetAlert2 (already included in main layout, but ensure it's available) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const actionModalElement = document.getElementById('actionModal');
        const actionModal = new bootstrap.Modal(actionModalElement);

        if (calendarEl) {
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                editable: false, // Set to true if you want to allow dragging/resizing events
                selectable: true, // Allow date selection for new events (if implemented)
                dayMaxEvents: true, // Allow "more" link when too many events
                eventDidMount: function(info) {
                    // Add custom data attributes for styling/identification if needed
                    if (info.event.extendedProps.status) {
                        info.el.setAttribute('data-status', info.event.extendedProps.status);
                    }
                },
                events: {
                    url: '<?= base_url('admin/calendar/getEvents') ?>', // AJAX endpoint to fetch events
                    method: 'GET',
                    failure: function() {
                        Swal.fire('Error', 'There was an error while fetching events!', 'error');
                    },
                    // You can add more parameters here if your backend needs them
                    // extraParams: function() { return { custom_param: 'something' }; }
                },
                eventClick: function(info) {
                    // Populate and show the modal with event details
                    document.getElementById('event_type').textContent = info.event.extendedProps.type || 'N/A';
                    document.getElementById('event_title').textContent = info.event.title || 'N/A';
                    document.getElementById('event_start').textContent = info.event.start ? info.event.start.toLocaleString() : 'N/A';
                    document.getElementById('event_end').textContent = info.event.end ? info.event.end.toLocaleString() : 'N/A';
                    document.getElementById('event_status').textContent = info.event.extendedProps.status || 'N/A';
                    document.getElementById('event_job_no').textContent = info.event.extendedProps.job_no || 'N/A';
                    document.getElementById('event_vehicle').textContent = info.event.extendedProps.vehicle || 'N/A';
                    document.getElementById('event_customer').textContent = info.event.extendedProps.customer || 'N/A';
                    document.getElementById('event_mechanic').textContent = info.event.extendedProps.mechanic || 'N/A';
                    document.getElementById('event_description').textContent = info.event.extendedProps.description || 'N/A';

                    actionModal.show();
                },
                // If you implement selectable: true, you might add:
                select: function(info) {
                    // Open a modal to add a new event
                    openModal('<?= base_url('admin/calendar/addEventForm') ?>?start=${info.startStr}&end=${info.endStr}', 'Add New Event');
                },
            });
            calendar.render();
        }
    });

    // Helper to open the actionModal (if needed from other parts of the calendar page)
    // This is already defined globally in layouts/main, but repeated here for clarity if this were a standalone view
    /*
    function openModal(url, title = 'Form') {
        const modalElement = document.getElementById('actionModal');
        const modal = new bootstrap.Modal(modalElement);
        const modalTitle = modalElement.querySelector('.modal-title');
        const modalContent = document.getElementById('modalContent');

        modalContent.innerHTML = `
            <div class="d-flex justify-content-center align-items-center" style="min-height: 100px;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        modalTitle.textContent = title;

        modal.show();

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok ' + response.statusText);
            return response.text();
        })
        .then(data => { modalContent.innerHTML = data; })
        .catch(error => {
            modalTitle.textContent = 'Error';
            modalContent.innerHTML = `<div class="alert alert-danger" role="alert">Error loading content: ${error.message}. Please try again.</div>`;
            console.error('Error loading modal content:', error);
        });
    }
    window.openModal = openModal;
    */
</script>

<?= $this->endSection() ?>
