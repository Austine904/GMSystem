document.addEventListener('DOMContentLoaded', function () {
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
            editable: true,
            selectable: true,
            dayMaxEvents: true,
            

            // Fetch events from server
            events: {
                url: `${BASE_URL}admin/calendar/getEvents`,
                method: 'GET',
                failure: function () {
                    Swal.fire('Error', 'There was an error while fetching events!', 'error');
                }
            },

            // Handle rendering extra data
            eventDidMount: function (info) {
                const { status, type } = info.event.extendedProps;

                // For styling or identification
                if (status) {
                    info.el.setAttribute('data-status', status);
                }
                if (type) {
                    info.el.setAttribute('data-type', type);
                }
            },

            // When an event is clicked
            eventClick: function (info) {
                info.jsEvent.preventDefault(); // prevent default browser behavior
                populateEventModal(info.event);
                actionModal.show();
            },

            // When a date is selected
            select: function (info) {
                const url = `${BASE_URL}admin/calendar/addEventForm?start=${info.startStr}&end=${info.endStr}`;
                openModal(url, 'Add New Event');
            }
        });

        calendar.render();
    }

    // Helper function to populate the event details modal
    function populateEventModal(event) {
        const props = event.extendedProps;
        const safe = (val) => val ?? 'N/A';

        document.getElementById('event_type').textContent = safe(props.type);
        document.getElementById('event_title').textContent = safe(event.title);
        document.getElementById('event_start').textContent = event.start?.toLocaleString() ?? 'N/A';
        document.getElementById('event_end').textContent = event.end?.toLocaleString() ?? 'N/A';
        document.getElementById('event_status').textContent = safe(props.status);
        document.getElementById('event_job_no').textContent = safe(props.job_no);
        document.getElementById('event_vehicle').textContent = safe(props.vehicle);
        document.getElementById('event_customer').textContent = safe(props.customer);
        document.getElementById('event_mechanic').textContent = safe(props.mechanic);
        document.getElementById('event_description').textContent = safe(props.description);
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