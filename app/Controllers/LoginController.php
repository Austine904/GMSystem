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

        $phone = $this->request->getPost('phone');
        $password = $this->request->getPost('password');

        $builder = $db->table('users');
        $user = $builder->where('phone', $phone)->get()->getRowArray();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'user_id' => $user['id'],
                    'user_name' => $user['name'],
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
