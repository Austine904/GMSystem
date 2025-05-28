<?php

namespace App\Controllers;
use CodeIgniter\Controller;

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

    public function index()
    {
        $role = $this->session->get('role');
        if (!in_array($role, ['admin', 'receptionist'])) {
            return redirect()->to('/login');
        }

        $service_advisors = $this->db->table('users')
            ->where('role', 'admin')
            ->get()
            ->getResult();

        return view('job/job_intake_form', ['service_advisors' => $service_advisors]);
    }

    public function search()
    {
        $search = $this->request->getGet('search');
        $response = [];

        $customers = $this->db->table('customers')
            ->groupStart()
                ->like('name', $search)
                ->orLike('phone', $search)
            ->groupEnd()
            ->get()
            ->getResult();

        foreach ($customers as $cust) {
            $response[] = ['label' => $cust->name . ' - ' . $cust->phone, 'value' => $cust->id];
        }

        $vehicles = $this->db->table('vehicles')
            ->groupStart()
                ->like('registration_number', $search)
                ->orLike('chassis_number', $search)
                ->orLike('vin', $search)
            ->groupEnd()
            ->get()
            ->getResult();

        foreach ($vehicles as $veh) {
            $response[] = ['label' => $veh->registration_number . ' - ' . $veh->chassis_number, 'value' => $veh->id];
        }

        return $this->response->setJSON($response);
    }

    public function create_job_card()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'problem_description' => 'required',
            'fuel_level' => 'required',
            'mileage' => 'required|numeric',
            'service_advisor' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['status' => 'error', 'errors' => $validation->getErrors()]);
        }

        $customerId = $this->request->getPost('customer_id');
        $vehicleId = $this->request->getPost('vehicle_id');

        // Insert new customer if needed
        if ($customerId === 'new') {
            $custData = [
                'name'  => $this->request->getPost('new_customer_name'),
                'phone' => $this->request->getPost('new_customer_phone'),
                'email' => $this->request->getPost('new_customer_email')
            ];
            $this->db->table('customers')->insert($custData);
            $customerId = $this->db->insertID();
        }

        // Insert new vehicle if needed
        if ($vehicleId === 'new') {
            $vehData = [
                'registration_number' => $this->request->getPost('new_registration_number'),
                'make' => $this->request->getPost('new_make'),
                'model' => $this->request->getPost('new_model'),
                'year_of_manufacture' => $this->request->getPost('new_year'),
                'chassis_number' => $this->request->getPost('new_chassis'),
                'engine_number' => $this->request->getPost('new_engine'),
                'fuel_type' => $this->request->getPost('new_fuel_type'),
                'transmission' => $this->request->getPost('new_transmission'),
                'owner_id' => $customerId,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->table('vehicles')->insert($vehData);
            $vehicleId = $this->db->insertID();
        }

        $jobNo = $this->_generate_job_no();

        $jobData = [
            'job_no' => $jobNo,
            'customer_id' => $customerId,
            'vehicle_id' => $vehicleId,
            'problem_description' => $this->request->getPost('problem_description'),
            'fuel_level' => $this->request->getPost('fuel_level'),
            'mileage' => $this->request->getPost('mileage'),
            'service_advisor' => $this->request->getPost('service_advisor'),
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->table('job_cards')->insert($jobData);
        $jobCardId = $this->db->insertID();

        // Photo uploads
        $this->_upload_photos($jobCardId);

        return $this->response->setJSON(['status' => 'success', 'message' => 'Job Card created!', 'job_card_id' => $jobCardId]);
    }

    private function _generate_job_no()
    {
        $today = date('Ymd');
        $count = $this->db->table('job_cards')
            ->where('DATE(created_at)', date('Y-m-d'))
            ->countAllResults();

        return 'JOB-' . $today . '-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }

    private function _upload_photos($jobCardId)
    {
        $files = $this->request->getFiles();
        if (isset($files['photos'])) {
            foreach ($files['photos'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(WRITEPATH . 'uploads/job_photos', $newName);
                    $this->db->table('job_card_photos')->insert([
                        'job_card_id' => $jobCardId,
                        'file_name' => $newName
                    ]);
                }
            }
        }
    }
}
