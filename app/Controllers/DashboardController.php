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
            'userId' => session()->get('user_id'),
        ];

        return view('dashboard', $data);
    }

    public function admin()
    {
        helper('activity');
        helper('time');
        // Check login and admin role
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        $recentActivity = [];

        // Jobs
        $jobs = $db->query("SELECT id, updated_at, status FROM jobs ORDER BY updated_at DESC LIMIT 3")->getResultArray();
        foreach ($jobs as $job) {
            $recentActivity[] = [
                'type' => 'jobs',
                'icon' => 'bi-briefcase',
                'text' => "Job #{$job['id']} status updated to '{$job['status']}'",
                'time' => timeAgo($job['updated_at']),
            ];
        }

        // Users
        $users = $db->query("SELECT id, first_name, last_name, role, created_at FROM users ORDER BY created_at DESC LIMIT 3")->getResultArray();
        foreach ($users as $user) {
            $name = esc($user['first_name'] . ' ' . $user['last_name']);
            $recentActivity[] = [
                'type' => 'users',
                'icon' => 'bi-person-plus',
                'text' => "New user <a href='#' class='activity-link'>{$name}</a> ({$user['role']}) registered by admin.",
                'time' => timeAgo($user['created_at']),
            ];
        }

        // Vehicles
        $vehicles = $db->query("SELECT registration_number, make, model, owner_id, created_at FROM vehicles ORDER BY created_at DESC LIMIT 3")->getResultArray();
        foreach ($vehicles as $v) {
            $vehicleText = "{$v['make']} {$v['model']} ({$v['registration_number']})";
            $recentActivity[] = [
                'type' => 'vehicles',
                'icon' => 'bi-car-front',
                'text' => "New vehicle <a href='#' class='activity-link'>{$vehicleText}</a> registered.",
                'time' => timeAgo($v['created_at']),
            ];
        }

        // Sort all activity by timestamp descending
        usort($recentActivity, fn($a, $b) => strtotime($b['time']) - strtotime($a['time']));


        // Count total users
        $userCount = $db->table('users')
            ->selectCount('id', 'total_users')
            ->get()
            ->getRow()
            ->total_users ?? 0;

        // Count total vehicles
        $vehicleCount = $db->table('vehicles')
            // ->selectCount('id', 'total_vehicles')
            ->selectCount('status', 'total_vehicles')
            ->where('status', 'Available')
            ->get()
            ->getRow()
            ->total_vehicles ?? 0;

        // Latest 5 users
        $latestUsers = $db->table('users')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        // Latest 5 vehicles
        $latestVehicles = $db->table('vehicles')
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        // Get job status counts in a single query
        $jobStatusQuery = $db->table('jobs')
            ->select("status, COUNT(*) as count")
            ->groupBy("status")
            ->get()
            ->getResult();

        // Initialize default values
        $jobStatusData = [
            'active' => 0,
            'completed' => 0,
            'pending' => 0,
            'cancelled' => 0,
        ];

        foreach ($jobStatusQuery as $row) {
            $status = strtolower($row->status);
            if (array_key_exists($status, $jobStatusData)) {
                $jobStatusData[$status] = (int)$row->count;
            }
        }

        // Count total jobs
        $totalJobsQuery = array_sum($jobStatusData);

        $data = [
            'userCount'       => $userCount,
            'vehicleCount'    => $vehicleCount,
            'latestUsers'     => $latestUsers,
            'latestVehicles'  => $latestVehicles,
            'activeJobs'      => $jobStatusData['active'],
            'completedJobs'   => $jobStatusData['completed'],
            'pendingJobs'     => $jobStatusData['pending'],
            'totalJobs'       => $totalJobsQuery,
            'jobStatusData'   => json_encode($jobStatusData),
        ];

        // Merge the data arrays
        $mergedData = array_merge($data, ['recentActivity' => $recentActivity]);

        // Return the view with the combined data
        return view('admin/dashboard', $mergedData);
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

    public function unauthorized()
    {
        return view('errors/unauthorized');
    }
}
