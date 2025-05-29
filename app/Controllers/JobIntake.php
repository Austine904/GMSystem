<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface as ResponseInterfaceAlias;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\Files\File;
use CodeIgniter\HTTP\Files\FileCollection;
use CodeIgniter\HTTP\Files\FileInterface;
use CodeIgniter\HTTP\Files\File as FileAlias;
use CodeIgniter\HTTP\Files\FileCollection as FileCollectionAlias;
use CodeIgniter\HTTP\Files\UploadedFile as UploadedFileAlias;
use CodeIgniter\Validation\Validation;
use CodeIgniter\Validation\ValidationInterface;
use CodeIgniter\Validation\Exceptions\ValidationException;
use CodeIgniter\HTTP\Cookie;
use CodeIgniter\HTTP\CookieInterface;
use CodeIgniter\HTTP\CookieCollection;
use CodeIgniter\HTTP\CookieCollection as CookieCollectionAlias;
use CodeIgniter\HTTP\Cookie as CookieAlias;
use CodeIgniter\HTTP\RedirectResponse as RedirectResponseAlias;
use CodeIgniter\API\ResponseTrait;


class JobIntake extends Controller
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = session();
        helper(['url', 'form']);
    }


    // public function search()
    // {
    //     $search = $this->request->getGet('search');
    //     $response = [];

    //     $customers = $this->db->table('customers')
    //         ->groupStart()
    //         ->like('name', $search)
    //         ->orLike('phone', $search)
    //         ->groupEnd()
    //         ->get()
    //         ->getResult();

    //     foreach ($customers as $cust) {
    //         $response[] = ['label' => $cust->name . ' - ' . $cust->phone, 'value' => $cust->id];
    //     }

    //     $vehicles = $this->db->table('vehicles')
    //         ->groupStart()
    //         ->like('registration_number', $search)
    //         ->orLike('chassis_number', $search)
    //         ->orLike('vin', $search)
    //         ->groupEnd()
    //         ->get()
    //         ->getResult();

    //     foreach ($vehicles as $veh) {
    //         $response[] = ['label' => $veh->registration_number . ' - ' . $veh->chassis_number, 'value' => $veh->id];
    //     }

    //     return $this->response->setJSON($response);
    // }

    // public function create_job_card()
    // {
    //     $validation = \Config\Services::validation();
    //     $validation->setRules([
    //         'problem_description' => 'required',
    //         'fuel_level' => 'required',
    //         'mileage' => 'required|numeric',
    //         'service_advisor' => 'required'
    //     ]);

    //     if (!$validation->withRequest($this->request)->run()) {
    //         return $this->response->setJSON(['status' => 'error', 'errors' => $validation->getErrors()]);
    //     }

    //     $customerId = $this->request->getPost('customer_id');
    //     $vehicleId = $this->request->getPost('vehicle_id');

    //     // Insert new customer if needed
    //     if ($customerId === 'new') {
    //         $custData = [
    //             'name'  => $this->request->getPost('new_customer_name'),
    //             'phone' => $this->request->getPost('new_customer_phone'),
    //             'email' => $this->request->getPost('new_customer_email')
    //         ];
    //         $this->db->table('customers')->insert($custData);
    //         $customerId = $this->db->insertID();
    //     }

    //     // Insert new vehicle if needed
    //     if ($vehicleId === 'new') {
    //         $vehData = [
    //             'registration_number' => $this->request->getPost('new_registration_number'),
    //             'make' => $this->request->getPost('new_make'),
    //             'model' => $this->request->getPost('new_model'),
    //             'year_of_manufacture' => $this->request->getPost('new_year'),
    //             'chassis_number' => $this->request->getPost('new_chassis'),
    //             'engine_number' => $this->request->getPost('new_engine'),
    //             'fuel_type' => $this->request->getPost('new_fuel_type'),
    //             'transmission' => $this->request->getPost('new_transmission'),
    //             'owner_id' => $customerId,
    //             'created_at' => date('Y-m-d H:i:s')
    //         ];
    //         $this->db->table('vehicles')->insert($vehData);
    //         $vehicleId = $this->db->insertID();
    //     }

    //     $jobNo = $this->_generate_job_no();

    //     $jobData = [
    //         'job_no' => $jobNo,
    //         'customer_id' => $customerId,
    //         'vehicle_id' => $vehicleId,
    //         'problem_description' => $this->request->getPost('problem_description'),
    //         'fuel_level' => $this->request->getPost('fuel_level'),
    //         'mileage' => $this->request->getPost('mileage'),
    //         'service_advisor' => $this->request->getPost('service_advisor'),
    //         'status' => 'pending',
    //         'created_at' => date('Y-m-d H:i:s')
    //     ];
    //     $this->db->table('job_cards')->insert($jobData);
    //     $jobCardId = $this->db->insertID();

    //     // Photo uploads
    //     $this->_upload_photos($jobCardId);

    //     return $this->response->setJSON(['status' => 'success', 'message' => 'Job Card created!', 'job_card_id' => $jobCardId]);
    // }

    // private function _generate_job_no()
    // {
    //     $today = date('Ymd');
    //     $count = $this->db->table('job_cards')
    //         ->where('DATE(created_at)', date('Y-m-d'))
    //         ->countAllResults();

    //     return 'JOB-' . $today . '-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    // }

    // private function _upload_photos($jobCardId)
    // {
    //     $files = $this->request->getFiles();
    //     if (isset($files['photos'])) {
    //         foreach ($files['photos'] as $file) {
    //             if ($file->isValid() && !$file->hasMoved()) {
    //                 $newName = $file->getRandomName();
    //                 $file->move(WRITEPATH . 'uploads/job_photos', $newName);
    //                 $this->db->table('job_card_photos')->insert([
    //                     'job_card_id' => $jobCardId,
    //                     'file_name' => $newName
    //                 ]);
    //             }
    //         }
    //     }
    // }

    use ResponseTrait;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->db = \Config\Database::connect();
        $this->session = session();
        // $this->form_validation = \Config\Services::validation();
        // $this->upload = \Config\Services::upload();
        $this->helpers = ['url', 'form'];
    }



    // Displays the initial job intake form
    public function index()
    {
        $role = $this->session->get('role');
        if (!in_array($role, ['admin', 'receptionist'])) {
            return redirect()->to('/login');
        }

        $service_advisors = $this->db->table('users')
            ->where('role', 'mechanic')
            ->get()
            ->getResultArray();

        return view('job/job_intake_form', ['service_advisors' => $service_advisors]);
    }

    // AJAX endpoint for searching customers and vehicles
    public function search()
    {
        if (!$this->session->get('logged_in')) {
            return $this->respond(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $query = $this->request->getVar('query');

        $results = [
            'customers' => [],
            'vehicles' => []
        ];

        if (!empty($query)) {
            $customerModel = $this->db->table('customers');
            $customerModel->like('phone', $query);
            $customerModel->orLike('name', $query);
            $results['customers'] = $customerModel->get()->getResultArray();

            $vehicleModel = $this->db->table('vehicles');
            $vehicleModel->like('registration_number', $query);
            $vehicleModel->orLike('chassis_number', $query);
            $vehicleModel->orLike('vin', $query);
            $vehicles = $vehicleModel->get()->getResultArray();

            foreach ($vehicles as &$vehicle) {
                $owner = $this->db->table('customers')->where('id', $vehicle['owner_id'])->get()->getRowArray();
                $vehicle['owner_name'] = $owner ? $owner['name'] : 'N/A';
            }
            $results['vehicles'] = $vehicles;
        }

        return $this->respond($results);
    }

    // AJAX endpoint for creating a new job card
    public function create_job_card()
    {
        if (!$this->session->get('logged_in')) {
            return $this->respond(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $user_role = $this->session->get('role');
        if ($user_role !== 'admin' && $user_role !== 'receptionist') {
            return $this->respond(['status' => 'error', 'message' => 'Forbidden: Insufficient permissions.'], 403);
        }

        $rules = [
            'customer_id' => 'required|integer',
            'vehicle_id' => 'required|integer',
            'reported_problem' => 'required|min_length[10]',
            'mileage_in' => 'required|integer|greater_than[0]',
            'fuel_level' => 'required|in_list[Empty,1/4,1/2,3/4,Full]',
            'initial_damage_notes' => 'permit_empty|max_length[500]',
            'assigned_service_advisor_id' => 'required|integer',
        ];

        if ($this->request->getPost('customer_id') === 'new') {
            $rules = array_merge($rules, [
                'new_customer_first_name' => 'required|max_length[50]',
                'new_customer_last_name' => 'required|max_length[50]',
                'new_customer_phone_number' => 'required|max_length[15]|is_unique[customers.phone]',
                'new_customer_email' => 'permit_empty|valid_email|max_length[255]',
            ]);
        }
        if ($this->request->getPost('vehicle_id') === 'new') {
            $rules = array_merge($rules, [
                'new_vehicle_license_plate' => 'required|max_length[20]|is_unique[vehicles.registration_number]',
                'new_vehicle_vin' => 'required|exact_length[17]|is_unique[vehicles.vin]',
                'new_vehicle_make' => 'required|max_length[50]',
                'new_vehicle_model' => 'required|max_length[50]',
                'new_vehicle_year' => 'required|integer|exact_length[4]',
                'new_vehicle_color' => 'permit_empty|max_length[30]',
            ]);
        }

        if (!$this->validate($rules)) {
            return $this->fail(['message' => 'Validation failed', 'errors' => $this->validator->getErrors()], 400);
        }

        $this->db->transStart();

        try {
            $customer_id = $this->request->getPost('customer_id');
            $vehicle_id = $this->request->getPost('vehicle_id');

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
            }

            if ($vehicle_id === 'new') {
                $vehicle_data = [
                    'owner_id' => $customer_id,
                    'registration_number' => $this->request->getPost('new_vehicle_license_plate'),
                    'vin' => $this->request->getPost('new_vehicle_vin'),
                    'make' => $this->request->getPost('new_vehicle_make'),
                    'model' => $this->request->getPost('new_vehicle_model'),
                    'year_of_manufacture' => $this->request->getPost('new_vehicle_year'),
                    'color' => $this->request->getPost('new_vehicle_color'),
                    'fuel_type' => 'Petrol', // Default or get from form if added
                    'transmission' => 'Automatic', // Default or get from form if added
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
                $this->db->table('vehicles')->where('id', $vehicle_id)->update([
                    'mileage' => $this->request->getPost('mileage_in'),
                    'reported_problem' => $this->request->getPost('reported_problem')
                ]);
            }

            $job_no = $this->_generate_job_no();
            $job_card_data = [
                'job_no' => $job_no,
                'customer_id' => $customer_id,
                'vehicle_id' => $vehicle_id,
                'date_in' => date('Y-m-d'),
                'time_in' => date('H:i:s'),
                'reported_problem' => $this->request->getPost('reported_problem'),
                'initial_damage_notes' => $this->request->getPost('initial_damage_notes'),
                'assigned_service_advisor_id' => $this->request->getPost('assigned_service_advisor_id'),
                'job_status' => 'Awaiting Diagnosis',
                'mileage_in' => $this->request->getPost('mileage_in'),
                'fuel_level' => $this->request->getPost('fuel_level')
            ];
            $this->db->table('job_cards')->insert($job_card_data);
            $job_card_id = $this->db->insertID();
            if (!$job_card_id) {
                throw new \Exception('Failed to create job card.');
            }

            $files = $this->request->getFileMultiple('job_card_photos');
            foreach ($files as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(ROOTPATH . 'public/uploads/job_card_photos', $newName);
                    $photo_data = [
                        'job_card_id' => $job_card_id,
                        'file_path' => 'uploads/job_card_photos/' . $newName,
                        'file_name' => $file->getClientName()
                    ];
                    $this->db->table('job_card_photos')->insert($photo_data);
                } elseif ($file->getError() !== 4) { // Ignore No File Upload error
                    throw new \Exception('Error uploading photo: ' . $file->getErrorString());
                }
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return $this->fail(['message' => 'Transaction failed'], 500);
            } else {
                return $this->respond(['status' => 'success', 'message' => 'Job Card created successfully!', 'job_id' => $job_card_id, 'job_no' => $job_no]);
            }
        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->fail(['message' => $e->getMessage()], 500);
        }
    }

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
        if (!$this->session->get('logged_in') || $this->session->get('role') !== 'mechanic') {
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
            ->select('job_card_parts_required.*, inventory.name, inventory.part_number')
            ->join('inventory', 'job_card_parts_required.inventory_id = inventory.id')
            ->where('job_card_id', $job_id)
            ->get()->getResultArray();

        $data['job_tasks'] = $this->db->table('job_card_labor_tasks')->where('job_card_id', $job_id)->get()->getResultArray();

        return view('mechanic_diagnosis_form', $data);
    }

    // AJAX endpoint to search for parts
    public function search_parts()
    {
        if (!$this->session->get('logged_in') || $this->session->get('role') !== 'mechanic') {
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
        if (!$this->session->get('logged_in') || $this->session->get('role') !== 'mechanic') {
            return $this->respond(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $job_id = $this->request->getPost('job_id');

        $rules = [
            'diagnosis' => 'required|min_length[10]',
            'estimated_labor_hours' => 'numeric|greater_than_equal_to[0]',
            'parts' => 'permit_empty|array',
            'tasks' => 'permit_empty|array',
        ];

        if (!$this->validate($rules)) {
            return $this->fail(['message' => 'Validation failed', 'errors' => $this->validator->getErrors()], 400);
        }

        $this->db->transStart();

        try {
            $update_data = [
                'diagnosis' => $this->request->getPost('diagnosis'),
                'estimated_labor_hours' => $this->request->getPost('estimated_labor_hours'),
                'job_status' => 'Diagnosis Complete'
            ];
            $this->db->table('job_cards')->where('id', $job_id)->update($update_data);

            // Parts
            $this->db->table('job_card_parts_required')->where('job_card_id', $job_id)->delete();
            $parts = $this->request->getPost('parts');
            if ($parts && is_array($parts)) {
                foreach ($parts as $part) {
                    $this->db->table('job_card_parts_required')->insert([
                        'job_card_id' => $job_id,
                        'inventory_id' => $part['inventory_id'],
                        'quantity_required' => $part['quantity_required'],
                        'unit_price_at_estimate' => $part['unit_price']
                    ]);
                }
            }

            // Tasks
            $this->db->table('job_card_labor_tasks')->where('job_card_id', $job_id)->delete();
            $tasks = $this->request->getPost('tasks');
            if ($tasks && is_array($tasks)) {
                foreach ($tasks as $task) {
                    $this->db->table('job_card_labor_tasks')->insert([
                        'job_card_id' => $job_id,
                        'task_name' => $task['task_name'],
                        'estimated_hours' => $task['estimated_hours'],
                        'notes' => $task['notes']
                    ]);
                }
            }

            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return $this->fail(['message' => 'Transaction failed'], 500);
            }

            return $this->respond([
                'status' => 'success',
                'message' => 'Diagnosis and estimate saved successfully!',
                'job_id' => $job_id
            ]);
        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->fail(['message' => 'Unexpected server error', 'error' => $e->getMessage()], 500);
        }
    }
}
