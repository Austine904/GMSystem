<?php

namespace App\Controllers;

use Config\Services;

use CodeIgniter\Controller;

class UsersController extends BaseController
{
    protected $session; // Define the $session property
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

    public function __construct()
    {
        $this->session = Services::session();
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

    public function details($id)
    {
        // Fetch user data from the database
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $query = \Config\Database::connect()->query("SELECT * FROM users WHERE id = ?", [$id]);
        $user = $query->getRowArray();

        if ($user) {
            // Prepare the response structure
            $response = [
                "photo" => !empty($user['photo']) ? base_url('uploads/users/' . $user['photo']) : base_url('uploads/users/default-photo.jpg'),
                "name" => $user['name'],
                "company_id" => $user['company_id'],
                "employment_date" => $user['employment_date'],
                "year_of_birth" => $user['year_of_birth'],
                "national_id" => $user['national_id'],
                "next_of_kin" => $user['next_of_kin'],
                "last_login" => $user['last_login'],
                "department" => $user['department'],
                "role_privileges" => $user['role_privileges'],
                "projects_managed" => $user['projects_managed'],
                "recent_activities" => $user['recent_activities'],
                "performance_metrics" => $user['performance_metrics']
            ];
            return $this->response->setJSON($response);
        } else {
            // If user not found, send error response
            return $this->response->setJSON(['error' => 'User not found'], 404);
        }
    }


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
    }

    public function addUserStep1()
    {
        // Validate the incoming data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'profile_picture'     => 'uploaded[profile_picture]|max_size[profile_picture,2048]|is_image[profile_picture]',
            'role'               => 'required',
            'company_id'         => 'required',
            'date_of_employment' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // If validation fails, send back the errors
            return view('step1_form', [
                'errors' => $validation->getErrors()
            ]);
        }

        // Store the image and get the path
        $profileImage = $this->request->getFile('profile_picture');
        if ($profileImage->isValid() && !$profileImage->hasMoved()) {
            $newName = $profileImage->getRandomName();
            $profileImage->move('uploads/profile_pictures', $newName);
            $imagePath = 'uploads/profile_pictures/' . $newName;
        }

        // Store Step 1 data in session
        session()->set('step1_data', [
            'profile_picture'     => $imagePath ?? null,
            'role'               => $this->request->getPost('role'),
            'company_id'         => $this->request->getPost('company_id'),
            'date_of_employment' => $this->request->getPost('date_of_employment')
        ]);

        // Load the view for Step 2 and return it as the AJAX response
                return $this->response->setJSON(['success' => true]);
        return view('users/add_step2', [
        ]);
    }


    public function add_step2()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name'   => 'required',
            'last_name'    => 'required',
            'dob'          => 'required|valid_date',
            'national_id'  => 'required',
            'gender'       => 'required',
            'phone_number' => 'required',
            'email'        => 'required|valid_email',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'errors'  => $validation->getErrors()
            ]);
        }

        // Store Step 2 data in the session
        session()->set('step2_data', [
            'first_name'   => $this->request->getPost('first_name'),
            'last_name'    => $this->request->getPost('last_name'),
            'dob'          => $this->request->getPost('dob'),
            'national_id'  => $this->request->getPost('national_id'),
            'gender'       => $this->request->getPost('gender'),
            'phone_number' => $this->request->getPost('phone_number'),
            'email'        => $this->request->getPost('email'),
        ]);

        return $this->response->setJSON(['success' => true]);
    }


    public function add_step3()
    {
        // Validate incoming data
        $validation = \Config\Services::validation();
        $validation->setRules([
            'kin_first_name'     => 'required',
            'kin_last_name'      => 'required',
            'relationship'       => 'required',
            'kin_phone_number'   => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // If validation fails, redirect back with errors
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Store Step 3 data in the session
        session()->set('step3_data', [
            'kin_first_name'   => $this->request->getPost('kin_first_name'),
            'kin_last_name'    => $this->request->getPost('kin_last_name'),
            'relationship'     => $this->request->getPost('relationship'),
            'kin_phone_number' => $this->request->getPost('kin_phone_number')
        ]);

        // Proceed to the final step or summary page
        return redirect()->to(base_url('user/preview'));
    }


    public function preview()
    {
        // Fetch data from session
        $step1Data = session()->get('step1_data');
        $step2Data = session()->get('step2_data');
        $step3Data = session()->get('step3_data');

        if (!$step1Data || !$step2Data || !$step3Data) {
            return redirect()->to(base_url('user/add'));
        }

        return view('users/preview', [
            'step1Data' => $step1Data,
            'step2Data' => $step2Data,
            'step3Data' => $step3Data
        ]);
    }

    public function submit()
    {
        // Fetch all the data from session
        $step1Data = session()->get('step1_data');
        $step2Data = session()->get('step2_data');
        $step3Data = session()->get('step3_data');

        if (!$step1Data || !$step2Data || !$step3Data) {
            return redirect()->to(base_url('user/add'));
        }

        // Insert user data
        $db = \Config\Database::connect();
        $this->$db->table('users')->insert([
            'first_name'    => $step1Data['first_name'],
            'last_name'     => $step1Data['last_name'],
            'email'         => $step1Data['email'],
            'phone_number'  => $step1Data['phone_number'],
            'role'          => $step1Data['role'],
            'company_id'    => $step1Data['company_id'],
            'date_employed' => $step1Data['date_employed'],
            'dob'           => $step2Data['dob'],
            'id_number'     => $step2Data['id_number'],
            'profile_pic'   => $step1Data['profile_pic'],
            'password'      => password_hash($step1Data['password'], PASSWORD_BCRYPT)
        ]);

        // Get the inserted user ID
        $userId = $this->$db->insertID();


        // Insert next of kin data
        $this->$db->table('next_of_kin')->insert([
            'user_id'       => $userId,
            'first_name'    => $step3Data['kin_first_name'],
            'last_name'     => $step3Data['kin_last_name'],
            'relationship'  => $step3Data['relationship'],
            'phone_number'  => $step3Data['kin_phone']
        ]);

        // Clear session data
        session()->remove(['step1_data', 'step2_data', 'step3_data']);

        return redirect()->to(base_url('admin/users'))->with('success', 'User added successfully!');
    }
}
