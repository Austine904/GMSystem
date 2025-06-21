
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const filterSelect = document.getElementById('eventTypeFilter');
    const searchInput = document.getElementById('eventSearchInput');
    const addEventBtn = document.getElementById('addEventBtn');
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const resetFiltersBtn = document.getElementById('resetFiltersBtn');
    const eventCountDisplay = document.getElementById('eventCount');
    const actionModalElement = document.getElementById('actionModal');
    const actionModal = new bootstrap.Modal(actionModalElement);
    let calendar;

    function getSelectedType() {
        return filterSelect.value;
    }

    function getSearchTerm() {
        return searchInput.value.toLowerCase();
    }

    function getStartDate() {
        return startDateInput.value ? new Date(startDateInput.value) : null;
    }

    function getEndDate() {
        return endDateInput.value ? new Date(endDateInput.value) : null;
    }

    function filterEvents(event) {
        const selectedType = getSelectedType();
        const searchTerm = getSearchTerm();
        const startDate = getStartDate();
        const endDate = getEndDate();
        const matchesType = selectedType === 'all' || event.extendedProps.type === selectedType;
        const matchesSearch = event.title.toLowerCase().includes(searchTerm);

        const eventStart = new Date(event.start);
        const withinStart = !startDate || eventStart >= startDate;
        const withinEnd = !endDate || eventStart <= endDate;

        return matchesType && matchesSearch && withinStart && withinEnd;
    }

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

    function getColorByType(type) {
        const colorMap = {
            service: '#198754',
            inspection: '#0dcaf0',
            repair: '#ffc107',
            cancelled: '#dc3545'
        };
        return colorMap[type] || '#6c757d';
    }

    function updateEventDate(id, start, end) {
        fetch(`${BASE_URL}admin/calendar/updateEventDate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ id, start, end })
        })
            .then(response => response.json())
            .then(result => {
                if (!result.success) throw new Error(result.message);
            })
            .catch(error => {
                console.error('Error updating event:', error);
                Swal.fire('Update Failed', 'Could not update event. Please try again.', 'error');
            });
    }

    if (calendarEl) {
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap5',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            height: 'auto',
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


    [filterSelect, searchInput, startDateInput, endDateInput].forEach(input => {
        input.addEventListener('input', renderCalendar);
    });

    addEventBtn.addEventListener('click', function () {
        const url = `${BASE_URL}admin/calendar/addEventForm`;
        openModal(url, 'Add New Event');
    });

    resetFiltersBtn?.addEventListener('click', () => {
        filterSelect.value = 'all';
        searchInput.value = '';
        startDateInput.value = '';
        endDateInput.value = '';
        renderCalendar();
    });

    renderCalendar();
});

