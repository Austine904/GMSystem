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
            editable: true, // Set to true if you want to allow dragging/resizing events
            selectable: true, // Allow date selection for new events (if implemented)
            dayMaxEvents: true, // Allow "more" link when too many events
            eventDidMount: function (info) {
                // Add custom data attributes for styling/identification if needed
                if (info.event.extendedProps.status) {
                    info.el.setAttribute('data-status', info.event.extendedProps.status);
                }
                if (info.event.extendedProps.type) {
                    info.el.setAttribute('data-type', info.event.extendedProps.type);
                }

            },
            events: {
                url: `${BASE_URL}admin/calendar/getEvents`,
                method: 'GET',
                failure: function () {
                    Swal.fire('Error', 'There was an error while fetching events!', 'error');
                },

                // You can add more parameters here if your backend needs them
                // extraParams: function() { return { custom_param: 'something' }; }

            },
            eventClick: function (info) {
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
            select: function (info) {
                // Open a modal to add a new event
                openModal(`${BASE_URL}admin/calendar/addEventForm?start=${info.startStr}&end=${info.endStr}`, 'Add New Event');
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