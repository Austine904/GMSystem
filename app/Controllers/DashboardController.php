<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'name' => session()->get('user_name'),
            'role' => session()->get('role'),
        ];

        return view('dashboard', $data);
    }

    public function admin()
    {
        return $this->restrictTo('admin', 'admin_dashboard');
    }

    public function mechanic()
    {
        return $this->restrictTo('mechanic', 'mechanic_dashboard');
    }

    private function restrictTo($requiredRole, $view)
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== $requiredRole) {
            return redirect()->to('/login');
        }

        return view($view, ['name' => session()->get('user_name')]);
    }

    public function receptionist()
    {
        return $this->restrictTo('receptionist', 'receptionist_dashboard');
    }

    public function customer()
    {
        return $this->restrictTo('customer', 'customer_dashboard');
    }
}
