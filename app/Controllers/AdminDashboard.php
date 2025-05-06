<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AdminDashboard extends BaseController
{
    // Show the admin dashboard
    public function index()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        return view('admin/dashboard');
    }
}
