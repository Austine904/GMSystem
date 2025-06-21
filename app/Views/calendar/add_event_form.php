<!-- add event form -->
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Add New Event</h5>
        </div>
        <div class="card-body">
            <form id="addEventForm">
                <div class="mb-3">
                    <label for="eventTitle" class="form-label">Event Title</label>
                    <input type="text" class="form-control" id="eventTitle" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="eventType" class="form-label">Event Type</label>
                    <select class="form-select" id="eventType" name="type" required>
                        <option value="" disabled selected>Select event type</option>
                        <option value="service">Service</option>
                        <option value="inspection">Inspection</option>
                        <option value="repair">Repair</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="eventStart" class="form-label">Start Time</label>
                    <input type="datetime-local" class="form-control" id="eventStart" name="start_time" required>
                </div>
                <div class="mb-3">
                    <label for="eventEnd" class="form-label">End Time</label>
                    <input type="datetime-local" class="form-control" id="eventEnd" name="end_time" required>
                </div>
                <div class="mb-3">
                    <label for="eventDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="eventDescription" name="description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Add Event</button>
            </form>
        </div>
    </div>