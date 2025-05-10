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

 public function __construct()
    {
        // Ensure that the session library is loaded correctly.
        $this->session = Services::session();
    }

    public function addUserStep1()
    {
        // Handle form submission for Step 1 (Company Info)
        if ($this->request->getMethod() === 'post') {
            // Validation rules
            $validationRules = [
                'first_name' => 'required|min_length[3]|max_length[50]',
                'last_name'  => 'required|min_length[3]|max_length[50]',
                'role'       => 'required',
                'company_id' => 'required',
                'phone_number' => 'required|regex_match[/^[0-9]{10}$/]',
                'email'      => 'required|valid_email',
                'password'   => 'required|min_length[8]',
                'profile_picture' => 'uploaded[profile_picture]|is_image[profile_picture]|max_size[profile_picture,2048]' // 2MB max
            ];

            if (!$this->validate($validationRules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // Store the form data in session
            $formData = [
                'first_name'    => $this->request->getPost('first_name'),
                'last_name'     => $this->request->getPost('last_name'),
                'role'          => $this->request->getPost('role'),
                'company_id'    => $this->request->getPost('company_id'),
                'phone_number'  => $this->request->getPost('phone_number'),
                'email'         => $this->request->getPost('email'),
                'password'      => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            ];

            // Handle file upload
            $file = $this->request->getFile('profile_picture');
            if ($file->isValid() && !$file->hasMoved()) {
                $imagePath = 'uploads/users/' . $file->getRandomName();
                $file->move(ROOTPATH . 'public/uploads/users', $imagePath);
                $formData['profile_picture'] = $imagePath;
            }

            // Store the form data in session
            $this->session->set('user_form_data', $formData);

            return redirect()->to('/user/step2'); // Go to step 2
        }

        return view('user/add_step2'); // Show step 1 form
    }

    public function addUserStep2()
    {
        // Show Step 2 form
        return view('users/add_step2');
    }

    public function submitUser()
    {
        // Collect all form data from session
        $formData = $this->session->get('user_form_data');
        if (!$formData) {
            return redirect()->to('/user/step1');
        }

        // Insert the data into the database
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->insert($formData);

        // Clear session data after successful submission
        $this->session->remove('user_form_data');

        return redirect()->to('/users')->with('success', 'User added successfully.');
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
        // $db = \Config\Database::connect();
        // $builder = $db->table('users');
        // $builder->select('id, name, company_id, employment_date, year_of_birth, national_id, next_of_kin, last_login, department, role_privileges, projects_managed, recent_activities, performance_metrics');
        // $user = $builder->where('id', $id)->get()->getRowArray();

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

    public function add_step2()
{
    // Validate incoming data
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
        // If validation fails, redirect back with errors
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
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

    // Proceed to Step 3
    return redirect()->to(base_url('user/add_step3'));
}

public function add_step3()
{
    // Validate incoming data
    $validation = \Config\Services::validation();
    $validation->setRules([
        'kin_first_name' => 'required',
        'kin_last_name'  => 'required',
        'relationship'   => 'required',
        'kin_phone'      => 'required',
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        // If validation fails, redirect back with errors
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    // Store Step 3 data in the session
    session()->set('step3_data', [
        'kin_first_name' => $this->request->getPost('kin_first_name'),
        'kin_last_name'  => $this->request->getPost('kin_last_name'),
        'relationship'   => $this->request->getPost('relationship'),
        'kin_phone'      => $this->request->getPost('kin_phone'),
    ]);

    // Proceed to Final Step (Review and Submit)
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
    $this->db->table('users')->insert([
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
    $userId = $this->db->insertID();

    // Insert next of kin data
    $this->db->table('next_of_kin')->insert([
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
