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
        $jobs = $this->db->table('jobs')
                         ->where('deleted_at', null) // Assuming soft delete, adjust as necessary
                         ->get()
                         ->getResultArray();

        return view('jobs/index', ['jobs' => $jobs]);
    }

    public function add()
    {
        return view('jobs/add');
    }

    public function store()
    {
        $rules = [
            'job_name' => 'required|min_length[3]',
            'description' => 'permit_empty|max_length[255]',
            'status' => 'required|in_list[pending,completed,cancelled]', // Example statuses
            'assigned_to' => 'permit_empty|integer', // Assuming this is a user ID
            'created_at' => 'required|valid_date',
            'updated_at' => 'permit_empty|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        try {
            $this->db->table('jobs')->insert($data);
            return redirect()->to('/admin/jobs')->with('success', 'Job added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

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
