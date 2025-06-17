<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Exception;

class CalendarController extends BaseController
{
    use ResponseTrait;

    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }

    /**
     * Displays the main calendar view.
     */
    public function index()
    {
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'You do not have permission to access this page.');
        }
        return view('calendar/calendar');
    }

    /**
     * AJAX endpoint to fetch events for FullCalendar.
     * Events include job drop-offs, estimated completions, etc.
     *
     * FullCalendar sends 'start' and 'end' parameters (ISO 8601 strings).
     */
    public function getEvents()
    {
        if (!$this->session->get('isLoggedIn')) {
            return $this->failUnauthorized('Unauthorized access to calendar events.');
        }

        $request = $this->request;
        $start_str = $request->getGet('start'); // Start of the viewable range
        $end_str = $request->getGet('end');   // End of the viewable range

        $events = [];

        try {
            // --- Fetch Job Card Events ---
            // Fetch jobs that are within the calendar's visible range.
            // Mechanic details will be fetched when viewing the event modal.
            $jobs = $this->db->table('job_cards')
                ->select('
                                 job_cards.id,
                                 job_cards.job_no,
                                 job_cards.diagnosis,
                                 job_cards.job_status,
                                 job_cards.date_in,
                                 job_cards.time_in,
                                 job_cards.end_date,
                                 job_cards.job_summary,
                                 vehicles.registration_number,
                                 customers.name as customer_name
                             ')
                ->join('vehicles', 'vehicles.id = job_cards.vehicle_id', 'left')
                ->join('customers', 'customers.id = job_cards.customer_id', 'left')
                ->where('job_cards.date_in >=', $start_str)
                ->where('job_cards.date_in <=', $end_str)


                ->orGroupStart()
                ->where('job_cards.end_date >=', $start_str)
                ->where('job_cards.end_date <=', $end_str)
                ->groupEnd()
                ->get()
                ->getResultArray();

            foreach ($jobs as $job) {
                // Event for Job Drop-off
                if (!empty($job['date_in'])) {
                    $startDateTime = $job['date_in'];
                    if (!empty($job['time_in'])) {
                        $startDateTime .= 'T' . $job['time_in']; // Combine date and time for full datetime
                    }

                    $events[] = [
                        'id'    => 'job-in-' . $job['id'],
                        'title' => 'Drop-off: ' . ($job['registration_number'] ?: 'N/A'),
                        'start' => $startDateTime,
                        'allDay' => empty($job['time_in']), // Set allDay if no specific time
                        'color' => '#007bff', // Primary blue for drop-offs
                        'extendedProps' => [
                            'type' => 'Job Drop-off',
                            'job_no' => $job['job_no'],
                            'status' => $job['job_status'],
                            'diagnosis' => $job['diagnosis'],
                            'vehicle' => $job['registration_number'],
                            'customer' => $job['customer_name'],
                            // Mechanic details will be fetched in the modal via job_details endpoint
                            'mechanic' => 'Loading...', // Placeholder
                            'description' => $job['job_summary'] ?: $job['diagnosis'],
                            'job_card_id' => $job['id'], // Pass job ID for modal fetching
                        ]
                    ];
                }

                // Event for Estimated Completion Date
                if (!empty($job['end_date']) && $job['job_status'] !== 'Completed' && $job['job_status'] !== 'Cancelled') {
                    $events[] = [
                        'id'    => 'job-est-' . $job['id'],
                        'title' => 'Est. Complete: ' . ($job['registration_number'] ?: 'N/A'),
                        'start' => $job['end_date'],
                        'allDay' => true, // Assuming estimated completion is usually a whole day
                        'color' => '#ffc107', // Warning yellow for estimated completion
                        'extendedProps' => [
                            'type' => 'Estimated Completion',
                            'job_no' => $job['job_no'],
                            'status' => $job['job_status'],
                            'diagnosis' => $job['diagnosis'],
                            'vehicle' => $job['registration_number'],
                            'customer' => $job['customer_name'],
                            // Mechanic details will be fetched in the modal via job_details endpoint
                            'mechanic' => 'Loading...', // Placeholder
                            'description' => 'Estimated completion for: ' . ($job['job_summary'] ?: $job['diagnosis']),
                            'job_card_id' => $job['id'], // Pass job ID for modal fetching
                        ]
                    ];
                }

                // Event for Completed Jobs (optional, to show recent completions)
                if ($job['job_status'] === 'Completed' && !empty($job['end_date'])) {
                    $events[] = [
                        'id'    => 'job-comp-' . $job['id'],
                        'title' => 'Completed: ' . ($job['registration_number'] ?: 'N/A'),
                        'start' => $job['end_date'], // Or actual_completion_date if available
                        'allDay' => true,
                        'color' => '#28a745', // Success green
                        'extendedProps' => [
                            'type' => 'Job Completed',
                            'job_no' => $job['job_no'],
                            'status' => $job['job_status'],
                            'diagnosis' => $job['diagnosis'],
                            'vehicle' => $job['registration_number'],
                            'customer' => $job['customer_name'],
                            // Mechanic details will be fetched in the modal via job_details endpoint
                            'mechanic' => 'Loading...', // Placeholder
                            'description' => 'Job successfully completed: ' . ($job['job_summary'] ?: $job['diagnosis']),
                            'job_card_id' => $job['id'], // Pass job ID for modal fetching
                        ]
                    ];
                }
            }

            // --- Fetch events from `calendar_events` table (if implemented) ---
            $calendarEvents = $this->db->table('calendar_events')
                ->where('start_time >=', $start_str)
                ->where('start_time <=', $end_str)
                ->get()
                ->getResultArray();

            foreach ($calendarEvents as $calEvent) {
                $events[] = [
                    'id'    => 'cal-' . $calEvent['id'], // Prefix to avoid ID collision
                    'title' => $calEvent['title'],
                    'start' => $calEvent['start_time'],
                    'end'   => $calEvent['end_time'],
                    'allDay' => (bool)$calEvent['all_day'],
                    'color' => $calEvent['color'],
                    'extendedProps' => [
                        'type' => $calEvent['event_type'],
                        'description' => $calEvent['description'],
                        'related_table' => $calEvent['related_table'],
                        'related_id' => $calEvent['related_id'],
                        // Other relevant fields for the modal display
                        'job_no' => ($calEvent['related_table'] === 'job_cards' && !empty($calEvent['related_id'])) ? 'Job ID: ' . $calEvent['related_id'] : 'N/A', // Example conditional data
                    ]
                ];
            }


            return $this->respond($events);
        } catch (DatabaseException $e) {
            // Log the specific database error for debugging
            log_message('error', 'Database error fetching calendar events: ' . $e->getMessage());
            return $this->failServerError('Database error: Could not retrieve calendar events.');
        } catch (Exception $e) {
            log_message('error', 'Error fetching calendar events: ' . $e->getMessage());
            return $this->failServerError('An unexpected error occurred while fetching calendar events.');
        }
    }
}
