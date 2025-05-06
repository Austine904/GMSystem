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

        // Query users
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $users = $builder->get()->getResultArray();

        return view('admin/users', ['users' => $users]);
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
}
