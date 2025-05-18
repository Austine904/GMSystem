<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DataException;

class VehicleController extends Controller
{
    public function index()
    {
        $db = \Config\Database::connect();
        $vehicles = $db->table('vehicles')->get()->getResultArray();
        return view('vehicles/index', ['vehicles' => $vehicles]);
    }

    public function fetchVehicles()
    {
        $db = \Config\Database::connect();
        $vehicles = $db->table('vehicles')->get()->getResultArray();
        return $this->response->setJSON($vehicles);
    }
    public function add()
    {
        $vehicleData = [
            'vehicle_number' => $this->request->getPost('vehicle_number'),
            'make' => $this->request->getPost('make'),
            'model' => $this->request->getPost('model'),
            'year' => $this->request->getPost('year'),
            'color' => $this->request->getPost('color'),
        ];
        $db = \Config\Database::connect();
        $db->table('vehicles')->insert($vehicleData);
        return view('vehicles/add');
    }

     public function store()
    {
        $data = $this->request->getPost();
        $db = \Config\Database::connect();
        $db->table('vehicles')->insert($data);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $db = \Config\Database::connect();
        $db->table('vehicles')->where('id', $id)->update($data);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('vehicles')->where('id', $id)->delete();

        return $this->response->setJSON(['status' => 'success']);
    }

    public function details($id)
{
    $db = db_connect();
    $query = $db->query("SELECT * FROM vehicles WHERE id = ?", [$id]);
    $vehicle = $query->getRowArray();

    if ($vehicle) {
        return $this->response->setJSON($vehicle);
    } else {
        return $this->response->setStatusCode(404)->setJSON(['message' => 'Vehicle not found']);
    }
}

}
