<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class JobIntake extends BaseController
{
    use ResponseTrait;

    protected $db;
    protected $session;
    protected $form_validation;
    protected $upload;
    protected $helpers = ['url', 'form']; // Ensure this is initialized as an array

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->db = \Config\Database::connect();
        $this->session = session();
        $this->form_validation = \Config\Services::validation();
        $this->upload = \Config\Services::upload();
    }

    // Displays the initial job intake form
    public function index()
    {
        // Check for 'isLoggedIn' for consistency with LoginController
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('auth/login');
        }

        $user_role = $this->session->get('role');
        if ($user_role !== 'admin' && $user_role !== 'receptionist') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('You are not authorized to access this page.');
        }

        // Fetch active service advisors for assignment dropdown
        $service_advisors = $this->db->table('users')
            ->select('id, first_name, last_name')
            ->where('role', 'mechanic')->get()->getResultArray();
        $data['mechanic'] = $service_advisors;
        return view('job_intake_form', $data);
    }

    // AJAX endpoint for searching customers and vehicles
    public function search()
    {
        // Check for 'isLoggedIn' for consistency with LoginController
        if (!$this->session->get('isLoggedIn')) {
            return $this->respond(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $query = $this->request->getVar('query');

        $results = [
            'customers' => [],
            'vehicles' => []
        ];

        $sanitizedQuery = (string)$query;

        if (!empty($sanitizedQuery)) {
            $customerModel = $this->db->table('customers');
            $customerModel->like('phone', $sanitizedQuery);
            $customerModel->orLike('name', $sanitizedQuery);
            $customers = $customerModel->get()->getResultArray();

            foreach ($customers as &$customer) {
                $customer['name'] = $customer['name'] ?? '';
                $customer['phone'] = $customer['phone'] ?? '';
                $customer['email'] = $customer['email'] ?? '';
                $customer['address'] = $customer['address'] ?? '';
            }
            $results['customers'] = $customers;

            $vehicleModel = $this->db->table('vehicles');
            $vehicleModel->like('registration_number', $sanitizedQuery);
            $vehicleModel->orLike('vin', $sanitizedQuery);
            $vehicleModel->orLike('chassis_number', $sanitizedQuery);
            $vehicles = $vehicleModel->get()->getResultArray();

            foreach ($vehicles as &$vehicle) {
                $owner = $this->db->table('customers')->where('id', $vehicle['owner_id'])->get()->getRowArray();

                $processedOwner = [
                    'id'      => $owner['id'] ?? null,
                    'name'    => $owner['name'] ?? '',
                    'phone'   => $owner['phone'] ?? '',
                    'email'   => $owner['email'] ?? '',
                    'address' => $owner['address'] ?? '',
                ];

                $vehicle['owner_name'] = $processedOwner['name'];
                $vehicle['owner'] = $processedOwner;

                $vehicle['registration_number'] = $vehicle['registration_number'] ?? '';
                $vehicle['vin'] = $vehicle['vin'] ?? '';
                $vehicle['make'] = $vehicle['make'] ?? '';
                $vehicle['model'] = $vehicle['model'] ?? '';
                $vehicle['color'] = $vehicle['color'] ?? '';
                $vehicle['reported_problem'] = $vehicle['reported_problem'] ?? '';
                $vehicle['engine_number'] = $vehicle['engine_number'] ?? '';
                $vehicle['chassis_number'] = $vehicle['chassis_number'] ?? '';
                $vehicle['fuel_type'] = $vehicle['fuel_type'] ?? '';
                $vehicle['transmission'] = $vehicle['transmission'] ?? '';
            }
            $results['vehicles'] = $vehicles;
        }

        return $this->respond($results);
    }

    // AJAX endpoint for creating a new job card
    public function create_job_card()
    {
        // Check for 'isLoggedIn' for consistency with LoginController
        if (!$this->session->get('isLoggedIn')) {
            return $this->respond(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $user_role = $this->session->get('role');
        if ($user_role !== 'admin' && $user_role !== 'receptionist') {
            return $this->respond(['status' => 'error', 'message' => 'Forbidden: Insufficient permissions.'], 403);
        }

        $rules = [
            'reported_problem' => 'required|min_length[10]',
            'mileage_in' => 'required|integer|greater_than_equal_to[0]',
            'fuel_level' => 'required|in_list[Empty,1/4,1/2,3/4,Full]',
            'initial_damage_notes' => 'permit_empty|max_length[500]',
            'assigned_service_advisor_id' => 'required|integer',
        ];

        // Conditional rules for customer_id and vehicle_id
        if ($this->request->getPost('customer_id') === 'new') {
            $rules = array_merge($rules, [
                'new_customer_first_name' => 'required|max_length[50]',
                'new_customer_last_name' => 'required|max_length[50]',
                'new_customer_phone_number' => 'required|max_length[15]|is_unique[customers.phone]',
                'new_customer_email' => 'permit_empty|valid_email|max_length[255]',
                'new_customer_address' => 'permit_empty',
            ]);
            $rules['customer_id'] = 'required'; // Ensure 'new' is present
        } else {
            $rules['customer_id'] = 'required|integer'; // Must be an integer if not 'new'
        }

        if ($this->request->getPost('vehicle_id') === 'new') {
            $rules = array_merge($rules, [
                'new_vehicle_license_plate' => 'required|max_length[20]|is_unique[vehicles.registration_number]',
                'new_vehicle_vin' => 'required|exact_length[17]|is_unique[vehicles.vin]',
                'new_vehicle_make' => 'required|max_length[50]',
                'new_vehicle_model' => 'required|max_length[50]',
                'new_vehicle_year' => 'required|integer|exact_length[4]|greater_than_equal_to[1900]|less_than_equal_to[' . (date('Y') + 1) . ']',
                'new_vehicle_engine_number' => 'required|max_length[50]|is_unique[vehicles.engine_number]',
                'new_vehicle_chassis_number' => 'required|max_length[50]|is_unique[vehicles.chassis_number]',
                'new_vehicle_fuel_type' => 'required|in_list[Petrol,Diesel,Electric,Hybrid]',
                'new_vehicle_color' => 'permit_empty|max_length[30]',
            ]);
            $rules['vehicle_id'] = 'required'; // Ensure 'new' is present
        } else {
            $rules['vehicle_id'] = 'required|integer'; // Must be an integer if not 'new'
        }

        if (!$this->validate($rules)) {
            return $this->fail(['message' => 'Validation failed', 'errors' => $this->validator->getErrors()], 400);
        }

        $this->db->transStart();

        try {
            $customer_id = $this->request->getPost('customer_id');
            $vehicle_id = $this->request->getPost('vehicle_id');

            // Handle new customer creation
            if ($customer_id === 'new') {
                $customer_data = [
                    'name' => $this->request->getPost('new_customer_first_name') . ' ' . $this->request->getPost('new_customer_last_name'),
                    'phone' => $this->request->getPost('new_customer_phone_number'),
                    'email' => $this->request->getPost('new_customer_email'),
                    'address' => $this->request->getPost('new_customer_address')
                ];
                $this->db->table('customers')->insert($customer_data);
                $customer_id = $this->db->insertID();
                if (!$customer_id) {
                    throw new \Exception('Failed to create new customer.');
                }
            } else {
                $customer_id = (int)$customer_id;
            }

            // Handle new vehicle creation or update existing one
            if ($vehicle_id === 'new') {
                $vehicle_data = [
                    'owner_id' => $customer_id,
                    'registration_number' => $this->request->getPost('new_vehicle_license_plate'),
                    'vin' => $this->request->getPost('new_vehicle_vin'),
                    'make' => $this->request->getPost('new_vehicle_make'),
                    'model' => $this->request->getPost('new_vehicle_model'),
                    'year_of_manufacture' => $this->request->getPost('new_vehicle_year'),
                    'engine_number' => $this->request->getPost('new_vehicle_engine_number'),
                    'chassis_number' => $this->request->getPost('new_vehicle_chassis_number'),
                    'fuel_type' => $this->request->getPost('new_vehicle_fuel_type'),
                    'color' => $this->request->getPost('new_vehicle_color'),
                    'status' => 'On Job',
                    'mileage' => $this->request->getPost('mileage_in'),
                    'reported_problem' => $this->request->getPost('reported_problem')
                ];
                $this->db->table('vehicles')->insert($vehicle_data);
                $vehicle_id = $this->db->insertID();
                if (!$vehicle_id) {
                    throw new \Exception('Failed to create new vehicle.');
                }
            } else {
                $vehicle_id = (int)$vehicle_id;
                $this->db->table('vehicles')->where('id', $vehicle_id)->update([
                    'mileage' => $this->request->getPost('mileage_in'),
                    'reported_problem' => $this->request->getPost('reported_problem')
                ]);
            }

            // Create Job Card
            $job_no = $this->_generate_job_no();
            $job_card_data = [
                'job_no' => $job_no,
                'customer_id' => $customer_id,
                'vehicle_id' => $vehicle_id,
                'date_in' => date('Y-m-d'),
                'time_in' => date('H:i:s'),
                'diagnosis' => $this->request->getPost('reported_problem'),
                'initial_damage_notes' => $this->request->getPost('initial_damage_notes'),
                'assigned_service_advisor_id' => (int)$this->request->getPost('assigned_service_advisor_id'),
                'job_status' => 'Awaiting Diagnosis',
                'mileage_in' => $this->request->getPost('mileage_in'),
                'fuel_level' => $this->request->getPost('fuel_level')
            ];

            $this->db->table('job_cards')->insert($job_card_data);
            $job_card_id = $this->db->insertID();

            if (!$job_card_id) {
                // --- DEBUGGING LINE START ---
                log_message('debug', 'DB Error on job card insert: ' . var_export($this->db->error(), true));
                // --- DEBUGGING LINE END ---
                throw new \Exception('Failed to create job card. Database insert failed.');
            }

            // Handle photo uploads
            $files = $this->request->getFiles();

            if (isset($files['job_card_photos'])) {
                foreach ($files['job_card_photos'] as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $uploadPath = ROOTPATH . 'public/uploads/job_card_photos/';
                        if (!is_dir($uploadPath)) {
                            mkdir($uploadPath, 0777, true);
                        }
                        $file->move($uploadPath, $newName);

                        $photo_data = [
                            'job_card_id' => $job_card_id,
                            'file_path' => 'uploads/job_card_photos/' . $newName,
                            'file_name' => $file->getClientName()
                        ];
                        $this->db->table('job_card_photos')->insert($photo_data);
                    } elseif ($file->getError() !== 4) {
                        log_message('error', 'Photo upload failed for job ID ' . $job_card_id . ': ' . $file->getErrorString());
                    }
                }
            }


            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Transaction failed, job card not fully created.');
            } else {
                return $this->respond(['status' => 'success', 'message' => 'Job Card created successfully!', 'job_id' => $job_card_id, 'job_no' => $job_no]);
            }
        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->fail(['message' => $e->getMessage()], 500);
        }
    }

    // Helper to generate a unique Job Number
    private function _generate_job_no()
    {
        $today = date('Ymd');
        $builder = $this->db->table('job_cards');
        $builder->like('job_no', 'JOB-' . $today, 'after');
        $count = $builder->countAllResults();
        return 'JOB-' . $today . '-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }

    // Display the mechanic's diagnosis and estimation form
    public function mechanic_view($job_id)
    {
        // Check for 'isLoggedIn' for consistency with LoginController
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') !== 'mechanic') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Unauthorized');
        }

        $jobModel = $this->db->table('job_cards')->where('id', $job_id);
        $data['job'] = $jobModel->get()->getRowArray();

        if (!$data['job']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Job not found.');
        }

        $data['customer'] = $this->db->table('customers')->where('id', $data['job']['customer_id'])->get()->getRowArray();
        $data['vehicle'] = $this->db->table('vehicles')->where('id', $data['job']['vehicle_id'])->get()->getRowArray();

        $data['job_parts'] = $this->db->table('job_card_parts_required')
            ->select('job_card_parts_required.*, inventory.name, inventory.part_number, inventory.unit_price')
            ->join('inventory', 'job_card_parts_required.inventory_id = inventory.id')
            ->where('job_card_id', $job_id)
            ->get()->getResultArray();

        $data['job_tasks'] = $this->db->table('job_card_labor_tasks')->where('job_card_id', $job_id)->get()->getResultArray();

        return view('mechanic_diagnosis_form', $data);
    }

    // AJAX endpoint to search for parts
    public function search_parts()
    {
        // Check for 'isLoggedIn' for consistency with LoginController
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') !== 'mechanic') {
            return $this->respond(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $query = $this->request->getVar('query');
        $results = [];

        if (!empty($query)) {
            $results = $this->db->table('inventory')
                ->like('name', $query)
                ->orLike('part_number', $query)
                ->get()->getResultArray();
        }

        return $this->respond($results);
    }

    // AJAX endpoint to save the mechanic's diagnosis and estimate
    public function save_diagnosis()
    {
        // Check for 'isLoggedIn' for consistency with LoginController
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') !== 'mechanic') {
            return $this->respond(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $job_id = $this->request->getVar('job_id');

        $rules = [
            'diagnosis' => 'required|min_length[10]',
            'estimated_labor_hours' => 'numeric|greater_than_equal_to[0]',
            'parts' => 'permit_empty|array',
            'tasks' => 'permit_empty|array',
        ];

        if ($this->request->getVar('parts')) {
            $rules['parts.*.inventory_id'] = 'required|integer';
            $rules['parts.*.quantity_required'] = 'required|integer|greater_than_equal_to[1]';
            $rules['parts.*.unit_price'] = 'required|numeric|greater_than_equal_to[0]';
        }

        if ($this->request->getVar('tasks')) {
            $rules['tasks.*.task_name'] = 'required|max_length[255]';
            $rules['tasks.*.estimated_hours'] = 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[999.99]';
            $rules['tasks.*.notes'] = 'permit_empty|max_length[500]';
        }


        if (!$this->validate($rules)) {
            return $this->fail(['message' => 'Validation failed', 'errors' => $this->validator->getErrors()], 400);
        }

        $this->db->transStart();

        try {
            $update_data = [
                'diagnosis' => $this->request->getVar('diagnosis'),
                'estimated_labor_hours' => $this->request->getVar('estimated_labor_hours'),
                'job_status' => 'Diagnosis Complete'
            ];
            $this->db->table('job_cards')->where('id', $job_id)->update($update_data);

            $this->db->table('job_card_parts_required')->where('job_card_id', $job_id)->delete();
            $parts = $this->request->getVar('parts');
            if ($parts && is_array($parts)) {
                foreach ($parts as $part) {
                    $part_data = [
                        'job_card_id' => $job_id,
                        'inventory_id' => $part['inventory_id'],
                        'quantity_required' => $part['quantity_required'],
                        'unit_price_at_estimate' => $part['unit_price']
                    ];
                    $this->db->table('job_card_parts_required')->insert($part_data);
                }
            }

            $this->db->table('job_card_labor_tasks')->where('job_card_id', $job_id)->delete();
            $tasks = $this->request->getVar('tasks');
            if ($tasks && is_array($tasks)) {
                foreach ($tasks as $task) {
                    $task_data = [
                        'job_card_id' => $job_id,
                        'task_name' => $task['task_name'],
                        'estimated_hours' => $task['estimated_hours'],
                        'notes' => $task['notes']
                    ];
                    $this->db->table('job_card_labor_tasks')->insert($task_data);
                }
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                throw new \Exception('Transaction failed, diagnosis not saved.');
            } else {
                return $this->respond(['status' => 'success', 'message' => 'Diagnosis and estimate saved successfully!']);
            }
        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->fail(['message' => $e->getMessage()], 500);
        }
    }
}
