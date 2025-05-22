<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AdminDashboard extends BaseController
{
    // Show the admin dashboard
    public function index()
    {
        // Check if the user is logged in and has the admin role
        // If not, redirect to the login page
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        // user count
        $userQuery = $db->table('users')
            ->select('COUNT(*) as total_users')
            ->get();
        $userCount = $userQuery->getRow()->total_users ?? 0;

        // vehicle count
        $vehicleQuery = $db->table('vehicles')
            ->select('COUNT(*) as total_vehicles')
            ->get();
        $vehicleCount = $vehicleQuery->getRow()->total_vehicles ?? 0;

        // Fetch the latest 5 users
        $latestUsersQuery = $db->table('users')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        $latestUsers = $latestUsersQuery->getResultArray();

        // Fetch the latest 5 vehicles
        $latestVehiclesQuery = $db->table('vehicles')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();
        $latestVehicles = $latestVehiclesQuery->getResultArray();

        $activeJobsQuery = $db->table('jobs')
            ->where('status', 'active')
            ->countAllResults();
        $completedJobsQuery = $db->table('jobs')
            ->where('status', 'completed')
            ->countAllResults();
        $pendingJobsQuery = $db->table('jobs')
            ->where('status', 'pending')
            ->countAllResults();
        $totalJobsQuery = $db->table('jobs')
            ->countAllResults();

        $jobStatusData = [
            'active' => $activeJobsQuery,
            'completed' => $completedJobsQuery,
            'pending' => $pendingJobsQuery,
            'cancelled' => $db->table('jobs')->where('status', 'cancelled')->countAllResults()
            
        ];


        // Fetch the data from the database
        $data = [
            'userCount' => $userCount,
            'vehicleCount' => $vehicleCount,
            'latestUsers' => $latestUsers,
            'latestVehicles' => $latestVehicles,
            'activeJobs' => $activeJobsQuery,
            'completedJobs' => $completedJobsQuery,
            'pendingJobs' => $pendingJobsQuery,
            'totalJobs' => $totalJobsQuery,
            'jobStatusData' => json_encode($jobStatusData),
        ];

        return view('admin/dashboard', $data);
    }
}
