<?php

namespace App\Controllers;
use App\Controllers\BaseController;


class JobsController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $jobs = $db->table('jobs')->get()->getResultArray();
        return view('jobs/index', ['jobs' => $jobs]);
    }

    public function add()
    {
        return view('jobs/add');
    }

    public function store()
    {
        $data = $this->request->getPost();
        $db = \Config\Database::connect();
        $db->table('jobs')->insert($data);
        return redirect()->to('/admin/jobs');
    }

    public function edit($id)
    {
        $db = \Config\Database::connect();
        $job = $db->table('jobs')->where('id', $id)->get()->getRowArray();
        return view('jobs/edit', ['job' => $job]);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $db = \Config\Database::connect();
        $db->table('jobs')->update($data, ['id' => $id]);
        return redirect()->to('/admin/jobs');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('jobs')->delete(['id' => $id]);
        return redirect()->to('/admin/jobs');
    }
}