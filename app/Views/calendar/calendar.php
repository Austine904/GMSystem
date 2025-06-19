<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>



<div class="container  mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📅 Garage Schedule</h2>
        <div class="legend d-flex">
            <div class="legend-item"><span style="background-color: #198754;"></span> Service</div>
            <div class="legend-item"><span style="background-color: #0dcaf0;"></span> Inspection</div>
            <div class="legend-item"><span style="background-color: #ffc107;"></span> Repair</div>
            <div class="legend-item"><span style="background-color: #dc3545;"></span> Cancelled</div>
        </div>
    </div>

    <div class="calendar-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <label for="eventTypeFilter" class="form-label">Filter by Type</label>
                <select id="eventTypeFilter" class="form-select d-inline-block" style="width: 200px;">
                    <option value="all">All</option>
                    <option value="service">Service</option>
                    <option value="inspection">Inspection</option>
                    <option value="repair">Repair</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="d-flex align-items-center gap-2">
                <input id="eventSearchInput" type="text" class="form-control" placeholder="Search events..." style="width: 200px;">
                <button id="addEventBtn" class="btn btn-primary">➕ Add Event</button>
            </div>
        </div>
        <div id="calendar"></div>
    </div>
</div>

<?= $this->include('calendar/modals') ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const filterSelect = document.getElementById('eventTypeFilter');
        const searchInput = document.getElementById('eventSearchInput');
        const addEventBtn = document.getElementById('addEventBtn');
        let calendar;

        function getSelectedType() {
            return filterSelect.value;
        }

        function getSearchTerm() {
            return searchInput.value.toLowerCase();
        }

        function filterEvents(event) {
            const selectedType = getSelectedType();
            const searchTerm = getSearchTerm();
            const matchesType = selectedType === 'all' || event.extendedProps.type === selectedType;
            const matchesSearch = event.title.toLowerCase().includes(searchTerm);
            return matchesType && matchesSearch;
        }

        function renderCalendar() {
            if (calendar) calendar.destroy();
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                themeSystem: 'bootstrap5',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                height: 'auto',
                events: function(fetchInfo, successCallback, failureCallback) {
                    fetch('/api/events')
                        .then(response => response.json())
                        .then(data => {
                            const filtered = data.filter(event => filterEvents(event));
                            successCallback(filtered);
                        })
                        .catch(err => failureCallback(err));
                }
            });
            calendar.render();
        }

        filterSelect.addEventListener('change', renderCalendar);
        searchInput.addEventListener('input', renderCalendar);
        addEventBtn.addEventListener('click', function() {
            // Replace with your modal or redirect logic
            alert('Add Event button clicked!');
        });

        renderCalendar();
    });
</script>


<?= $this->endSection() ?>