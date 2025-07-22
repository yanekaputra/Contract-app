<?php
require_once 'BaseController.php';
require_once dirname(__DIR__) . '/Models/Employee.php';
require_once dirname(__DIR__) . '/Models/Doctor.php';
require_once dirname(__DIR__) . '/Models/Contract.php';
require_once dirname(__DIR__) . '/Models/Placement.php';

class DoctorController extends BaseController {
    private $employeeModel;
    private $doctorModel;
    private $contractModel;
    private $placementModel;
    
    public function __construct() {
        $this->employeeModel = new Employee();
        $this->doctorModel = new Doctor();
        $this->contractModel = new Contract();
        $this->placementModel = new Placement();
    }
    
    public function index() {
        $this->requireLogin();
        
        $doctors = $this->doctorModel->getAllWithExpiryStatus();
        $this->view('doctors/index', ['doctors' => $doctors]);
    }
    
    public function create() {
        $this->requireRole(['admin', 'hr']);
        $this->view('doctors/create');
    }
    
    public function store() {
        $this->requireRole(['admin', 'hr']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/doctors');
        }
        
        try {
            // Create employee
            $employeeData = [
                'employee_code' => $this->employeeModel->generateEmployeeCode('doctor'),
                'full_name' => $_POST['full_name'],
                'birth_date' => $_POST['birth_date'],
                'birth_place' => $_POST['birth_place'],
                'gender' => $_POST['gender'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'employee_type' => 'doctor',
                'join_date' => $_POST['join_date'],
                'created_by' => $_SESSION['user_id']
            ];
            
            // Upload photo if exists
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
                $employeeData['photo'] = $this->uploadFile($_FILES['photo'], 'photo');
            }
            
            $employeeId = $this->employeeModel->create($employeeData);
            
            // Create doctor data
            $doctorData = [
                'employee_id' => $employeeId,
                'specialization' => $_POST['specialization'],
                'sub_specialization' => $_POST['sub_specialization'] ?? null,
                'str_number' => $_POST['str_number'],
                'str_issue_date' => $_POST['str_issue_date'],
                'str_expiry_date' => $_POST['str_expiry_date'],
                'sip_number' => $_POST['sip_number'],
                'sip_issue_date' => $_POST['sip_issue_date'],
                'sip_expiry_date' => $_POST['sip_expiry_date']
            ];
            
            // Upload documents
            if (isset($_FILES['str_file']) && $_FILES['str_file']['error'] === 0) {
                $doctorData['str_file'] = $this->uploadFile($_FILES['str_file'], 'str');
            }
            
            if (isset($_FILES['sip_file']) && $_FILES['sip_file']['error'] === 0) {
                $doctorData['sip_file'] = $this->uploadFile($_FILES['sip_file'], 'sip');
            }
            
            $this->doctorModel->create($doctorData);
            
            $this->redirect('/doctors', 'Data dokter berhasil ditambahkan');
            
        } catch (Exception $e) {
            $this->redirect('/doctors/create', 'Error: ' . $e->getMessage(), 'error');
        }
    }
    
    public function edit($id) {
        $this->requireRole(['admin', 'hr']);
        
        $employee = $this->employeeModel->findById($id);
        if (!$employee || $employee['employee_type'] !== 'doctor') {
            $this->redirect('/doctors', 'Data dokter tidak ditemukan', 'error');
        }
        
        $doctor = $this->doctorModel->getByEmployeeId($id);
        $contracts = $this->contractModel->getAllByEmployeeId($id);
        $currentPlacement = $this->placementModel->getCurrentPlacement($id);
        
        $data = [
            'employee' => $employee,
            'doctor' => $doctor,
            'contracts' => $contracts,
            'currentPlacement' => $currentPlacement
        ];
        
        $this->view('doctors/edit', $data);
    }
    
    public function update($id) {
        $this->requireRole(['admin', 'hr']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/doctors');
        }
        
        try {
            // Update employee
            $employeeData = [
                'full_name' => $_POST['full_name'],
                'birth_date' => $_POST['birth_date'],
                'birth_place' => $_POST['birth_place'],
                'gender' => $_POST['gender'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'updated_by' => $_SESSION['user_id']
            ];
            
            // Upload photo if exists
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
                $employee = $this->employeeModel->findById($id);
                $employeeData['photo'] = $this->uploadFile($_FILES['photo'], 'photo', $employee['photo']);
            }
            
            $this->employeeModel->update($id, $employeeData);
            
            // Update doctor data
            $doctor = $this->doctorModel->getByEmployeeId($id);
            
            $doctorData = [
                'specialization' => $_POST['specialization'],
                'sub_specialization' => $_POST['sub_specialization'] ?? null,
                'str_number' => $_POST['str_number'],
                'str_issue_date' => $_POST['str_issue_date'],
                'str_expiry_date' => $_POST['str_expiry_date'],
                'sip_number' => $_POST['sip_number'],
                'sip_issue_date' => $_POST['sip_issue_date'],
                'sip_expiry_date' => $_POST['sip_expiry_date']
            ];
            
            // Upload documents
            if (isset($_FILES['str_file']) && $_FILES['str_file']['error'] === 0) {
                $doctorData['str_file'] = $this->uploadFile($_FILES['str_file'], 'str', $doctor['str_file']);
            }
            
            if (isset($_FILES['sip_file']) && $_FILES['sip_file']['error'] === 0) {
                $doctorData['sip_file'] = $this->uploadFile($_FILES['sip_file'], 'sip', $doctor['sip_file']);
            }
            
            $this->doctorModel->update($doctor['id'], $doctorData);
            
            $this->redirect('/doctors', 'Data dokter berhasil diupdate');
            
        } catch (Exception $e) {
            $this->redirect("/doctors/edit/{$id}", 'Error: ' . $e->getMessage(), 'error');
        }
    }
    
    public function view($id) {
        $this->requireLogin();
        
        $employee = $this->employeeModel->getWithDetails($id);
        if (!$employee || $employee['employee_type'] !== 'doctor') {
            $this->redirect('/doctors', 'Data dokter tidak ditemukan', 'error');
        }
        
        $doctor = $this->doctorModel->getByEmployeeId($id);
        $contracts = $this->contractModel->getAllByEmployeeId($id);
        $placementHistory = $this->placementModel->getHistory($id);
        
        $data = [
            'employee' => $employee,
            'doctor' => $doctor,
            'contracts' => $contracts,
            'placementHistory' => $placementHistory
        ];
        
        $this->view('doctors/view', $data);
    }
    
    public function delete($id) {
        $this->requireRole('admin');
        
        try {
            $this->employeeModel->update($id, ['is_active' => 0]);
            $this->redirect('/doctors', 'Data dokter berhasil dihapus');
        } catch (Exception $e) {
            $this->redirect('/doctors', 'Error: ' . $e->getMessage(), 'error');
        }
    }
}