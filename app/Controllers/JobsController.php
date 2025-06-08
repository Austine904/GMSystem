<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class JobsController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('jobs')
            ->select('id, job_no, vehicle_id, description, status');

        $search = $this->request->getVar('search');
        if (!empty($search)) {
            $builder->like('job_no', $search)
                ->orLike('vehicle_id', $search);
        }

        $service_advisors = $db->table('users')
            ->where('role', 'mechanic')
            ->select('id, company_id, first_name, last_name')
            ->orderBy('first_name', 'ASC')   
            ->get()
            ->getResultArray();


        $perPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;

        $total = $builder->countAllResults(false);
        $jobs = $builder->limit($perPage, ($currentPage - 1) * $perPage)->get()->getResultArray();
        $pager = \Config\Services::pager();

        if ($this->request->isAJAX()) {
            return view('admin/jobs/jobs_list', ['jobs' => $jobs, 'pager' => $pager, ]);
        }

        return view('job/index', ['jobs' => $jobs, 'pager' => $pager, 'service_advisors' => $service_advisors]);
    }

    public function fetchJobs()
    {
        $builder = $this->db->table('jobs');
        $query = $builder->get();
        $result = $query->getResultArray();

        $jobs = [];
        foreach ($result as $row) {
            $jobs[] = [
                'id' => $row['id'],
                'job_no' => $row['job_no'],
                'vehicle_id' => $row['vehicle_id'],
                'description' => $row['description'],
                'status' => $row['status'],
                'received_date' => $row['received_date'],
                'start_date' => $row['start_date'],
                'end_date' => $row['end_date'],
                // 'assigned_to' => $row['assigned_to'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ];
        }

        return $this->response->setJSON(['data' => $jobs]);
    }

    public function add()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }
        $db = \Config\Database::connect();
        $service_advisors = $db->table('users')
            ->where('role', 'mechanic')
            ->select('id, company_id, first_name, last_name')
            ->orderBy('first_name', 'ASC')   
            ->get()
            ->getResultArray();
        return view('jobs/add', ['service_advisors' => $service_advisors]);

        
    }

    // public function store()
    // {
    //     $rules = [
    //         'job_name' => 'required|min_length[3]',
    //         'description' => 'permit_empty|max_length[255]',
    //         'status' => 'required|in_list[pending,completed,cancelled]', // Example statuses
    //         'assigned_to' => 'permit_empty|integer', // This is a user ID
    //         'created_at' => 'required|valid_date',
    //         'updated_at' => 'permit_empty|valid_date',
    //     ];

    //     if (!$this->validate($rules)) {
    //         return redirect()->back()
    //             ->withInput()
    //             ->with('errors', $this->validator->getErrors());
    //     }

    //     $data = $this->request->getPost();

    //     try {
    //         $this->db->table('jobs')->insert($data);
    //         return redirect()->to('/admin/jobs')->with('success', 'Job added successfully!');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
    //     }
    // }

    public function edit($id)
    {
        $job = $this->db->table('jobs')->where('id', $id)->get()->getRowArray();

        if (!$job) {
            return redirect()->to('/admin/jobs')->with('error', 'Job not found.');
        }

        return view('jobs/edit', ['job' => $job]);
    }

    public function update($id)
    {
        $rules = [
            'job_name' => 'required|min_length[3]',
            // Add other validation rules here
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        try {
            $this->db->table('jobs')->update($data, ['id' => $id]);
            return redirect()->to('/admin/jobs')->with('success', 'Job updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            // Soft delete
            $this->db->table('jobs')->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);

            // Hard delete
            $this->db->table('jobs')->delete(['id' => $id]);

            return redirect()->to('/admin/jobs')->with('success', 'Job deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->to('/admin/jobs')->with('error', 'Deletion failed: ' . $e->getMessage());
        }
    }
}
