<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class LoginController extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function auth()
    {
        $db = \Config\Database::connect();
        $session = session();

        
        $companyid = $this->request->getPost('company_id');
        $password = $this->request->getPost('password');
        $validation = \Config\Services::validation();
        $validation->setRules([
            'company_id' => 'required',
            'password' => 'required'
        ]);
        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
        // Check if the company ID exists in the database
        

        $builder = $db->table('users');
        $user = $builder->where('company_id', $companyid)->get()->getRowArray();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'user_id' => $user['id'],
                    'user_name' => $user['first_name'] . ' ' . $user['last_name'],
                    'role' => $user['role'],
                    'isLoggedIn' => true
                ];
                $session->set($sessionData);

                // Redirect by role
                if ($user['role'] === 'admin') {
                    return redirect()->to('/admin');
                } elseif ($user['role'] === 'mechanic') {
                    return redirect()->to('/mechanic');
                } else {
                    return redirect()->to('/dashboard');
                }
            } else {
                return redirect()->back()->with('error', 'Wrong password');
            }
        } else {
            return redirect()->back()->with('error', 'User not found');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
