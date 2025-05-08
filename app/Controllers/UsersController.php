<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class UsersController extends BaseController
{
    // Display all users
    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $query = $db->table('users');

        $search = $this->request->getVar('search');

        if (!empty($search)) {
            $query->like('name', $search)
                ->orLike('phone', $search)
                ->orLike('role', $search);
        }

        $perPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;

        $users = $query->limit($perPage, ($currentPage - 1) * $perPage)->get()->getResultArray();
        $pager = \Config\Services::pager();

        if ($this->request->isAJAX()) {
            return view('admin/users/user_list', ['users' => $users, 'pager' => $pager]);
        }

        return view('admin/users', ['users' => $users, 'pager' => $pager]);
    }

    // Show the add user form
    public function add()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        return view('admin/add_user');
    }

    // Handle adding a user
    public function create()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');
        $role = $this->request->getPost('role');
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        $db = \Config\Database::connect();
        $builder = $db->table('users');

        $data = [
            'name' => $name,
            'phone' => $phone,
            'role' => $role,
            'password' => $password
        ];

        $builder->insert($data);

        return redirect()->to('/admin/users')->with('success', 'User added successfully.');
    }

    // Handle editing a user (Form)
    public function edit($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $user = $builder->where('id', $id)->get()->getRowArray();

        return view('admin/edit_user', ['user' => $user]);
    }

    // Handle updating a user
    public function update($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');
        $role = $this->request->getPost('role');

        $data = [
            'name' => $name,
            'phone' => $phone,
            'role' => $role
        ];

        if ($this->request->getPost('password')) {
            $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            $data['password'] = $password;
        }

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('id', $id)->update($data);

        return redirect()->to('/admin/users')->with('success', 'User updated successfully.');
    }

    // Handle deleting a user
    public function delete($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('id', $id)->delete();

        return redirect()->to('/admin/users')->with('success', 'User deleted successfully.');
    }

    // Handle bulk actions (delete)
    public function bulk_action()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $userIds = $this->request->getPost('users');

        if ($userIds) {
            $db = \Config\Database::connect();
            $builder = $db->table('users');
            $builder->whereIn('id', $userIds)->delete();

            return redirect()->to('/admin/users')->with('success', 'Selected users deleted successfully.');
        } else {
            return redirect()->to('/admin/users')->with('error', 'No users selected for deletion.');
        }
    }

    // Handle viewing user details
   
    // Handle viewing user details in a modal
    public function view($id)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $user = $builder->where('id', $id)->get()->getRowArray();

        return view('admin/user_details', ['user' => $user]);
}}
