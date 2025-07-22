<?php
require_once 'BaseController.php';
require_once dirname(__DIR__) . '/Models/Employee.php';
require_once dirname(__DIR__) . '/Models/Staff.php';
require_once dirname(__DIR__) . '/Models/Contract.php';
require_once dirname(__DIR__) . '/Models/Placement.php';
require_once dirname(__DIR__) . '/Models/Unit.php';

class StaffController extends BaseController {
    private $employeeModel;
    private $staffModel;
    private $contractModel;
    private $placementModel;
    private $unitModel;
    
    public function __construct() {
        $this->employeeModel = new Employee();
        $this->staffModel = new Staff();
        $this->contractModel = new Contract();
        $this->placementModel = new Placement();
        $this->unitModel = new Unit();
    }
    
    public function index() {
        $this->requireLogin();
        
        $staff = $this->staffModel->getAllWithExpiryStatus();
        $this->view('staff/index', ['staff' => $staff]);
    }
    
    public function create() {
        $this->requireRole(['admin', 'hr']);
        
        $units = $this->unitModel->getActive();
        $this->view('staff/create', ['units' => $units]);
    }
    
    public function store() {
        $this->requireRole(['admin', 'hr']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/staff');
        }
        
        try {
            // Create employee
            $employeeData = [
                'employee_code' => $this->employeeModel->generateEmployeeCode('staff'),
                'full_name' => $_POST['full_name'],
                'birth_date' => $_POST['birth_date'],
                'birth_place' => $_POST['birth_place'],
                'gender' => $_POST['gender'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'employee_type' => 'staff',
                'join_date' => $_POST['join_date'],
                'created_by' => $_SESSION['user_id']
            ];
            
            // Upload photo if exists
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
                $employeeData['photo'] = $this->uploadFile($_FILES['photo'], 'photo');
            }
            
            $employeeId = $this->employeeModel->create($employeeData);
            
            // Create staff data
            $staffData = [
                'employee_id' => $employeeId,
                'position' => $_POST['position'],
                'department' => $_POST['department'],
                'education_level' => $_POST['education_level'],
                'has_str' => isset($_POST['has_str']) ? 1 : 0,
                'has_sip' => isset($_POST['has_sip']) ? 1 : 0
            ];
            
            // If has STR
            if ($staffData['has_str']) {
                $staffData['str_number'] = $_POST['str_number'];
                $staffData['str_issue_date'] = $_POST['str_issue_date'];
                $staffData['str_expiry_date'] = $_POST['str_expiry_date'];
                
                if (isset($_FILES['str_file']) && $_FILES['str_file']['error'] === 0) {
                    $staffData['str_file'] = $this->uploadFile($_FILES['str_file'], 'str');
                }
            }
            
            // If has SIP
            if ($staffData['has_sip']) {
                $staffData['sip_number'] = $_POST['sip_number'];
                $staffData['sip_issue_date'] = $_POST['sip_issue_date'];
                $staffData['sip_expiry_date'] = $_POST['sip_expiry_date'];
                
                if (isset($_FILES['sip_file']) && $_FILES['sip_file']['error'] === 0) {
                    $staffData['sip_file'] = $this->uploadFile($_FILES['sip_file'], 'sip');
                }
            }
            
            $this->staffModel->create($staffData);
            
            // Assign to unit if specified
            if (!empty($_POST['unit_id'])) {
                $this->placementModel->assignToUnit($employeeId, $_POST['unit_id'], [
                    'placement_reason' => 'Penempatan Awal',
                    'created_by' => $_SESSION['user_id']
                ]);
            }
            
            $this->redirect('/staff', 'Data staff berhasil ditambahkan');
            
        } catch (Exception $e) {
            $this->redirect('/staff/create', 'Error: ' . $e->getMessage(), 'error');
        }
    }
    
    public function edit($id) {
        $this->requireRole(['admin', 'hr']);
        
        $employee = $this->employeeModel->findById($id);
        if (!$employee || $employee['employee_type'] !== 'staff') {
            $this->redirect('/staff', 'Data staff tidak ditemukan', 'error');
        }
        
        $staff = $this->staffModel->getByEmployeeId($id);
        $contracts = $this->contractModel->getAllByEmployeeId($id);
        $currentPlacement = $this->placementModel->getCurrentPlacement($id);
        $units = $this->unitModel->getActive();
        
        $data = [
            'employee' => $employee,
            'staff' => $staff,
            'contracts' => $contracts,
            'currentPlacement' => $currentPlacement,
            'units' => $units
        ];
        
        $this->view('staff/edit', $data);
    }
    
    public function update($id) {
        $this->requireRole(['admin', 'hr']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/staff');
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
            
            // Update staff data
            $staff = $this->staffModel->getByEmployeeId($id);
            
            $staffData = [
                'position' => $_POST['position'],
                'department' => $_POST['department'],
                'education_level' => $_POST['education_level'],
                'has_str' => isset($_POST['has_str']) ? 1 : 0,
                'has_sip' => isset($_POST['has_sip']) ? 1 : 0
            ];
            
            // If has STR
            if ($staffData['has_str']) {
                $staffData['str_number'] = $_POST['str_number'];
                $staffData['str_issue_date'] = $_POST['str_issue_date'];
                $staffData['str_expiry_date'] = $_POST['str_expiry_date'];
                
                if (isset($_FILES['str_file']) && $_FILES['str_file']['error'] === 0) {
                    $staffData['str_file'] = $this->uploadFile($_FILES['str_file'], 'str', $staff['str_file']);
                }
            } else {
                $staffData['str_number'] = null;
                $staffData['str_issue_date'] = null;
                $staffData['str_expiry_date'] = null;
            }
            
            // If has SIP
            if ($staffData['has_sip']) {
                $staffData['sip_number'] = $_POST['sip_number'];
                $staffData['sip_issue_date'] = $_POST['sip_issue_date'];
                $staffData['sip_expiry_date'] = $_POST['sip_expiry_date'];
                
                if (isset($_FILES['sip_file']) && $_FILES['sip_file']['error'] === 0) {
                    $staffData['sip_file'] = $this->uploadFile($_FILES['sip_file'], 'sip', $staff['sip_file']);
                }
            } else {
                $staffData['sip_number'] = null;
                $staffData['sip_issue_date'] = null;
                $staffData['sip_expiry_date'] = null;
            }
            
            $this->staffModel->update($staff['id'], $staffData);
            
            $this->redirect('/staff', 'Data staff berhasil diupdate');
            
        } catch (Exception $e) {
            $this->redirect("/staff/edit/{$id}", 'Error: ' . $e->getMessage(), 'error');
        }
    }
    
    public function view($id) {
        $this->requireLogin();
        
        $employee = $this->employeeModel->getWithDetails($id);
        if (!$employee || $employee['employee_type'] !== 'staff') {
            $this->redirect('/staff', 'Data staff tidak ditemukan', 'error');
        }
        
        $staff = $this->staffModel->getByEmployeeId($id);
        $contracts = $this->contractModel->getAllByEmployeeId($id);
        $placementHistory = $this->placementModel->getHistory($id);
        
        $data = [
            'employee' => $employee,
            'staff' => $staff,
            'contracts' => $contracts,
            'placementHistory' => $placementHistory
        ];
        
        $this->view('staff/view', $data);
    }
    
    public function delete($id) {
        $this->requireRole('admin');
        
        try {
            $this->employeeModel->update($id, ['is_active' => 0]);
            $this->redirect('/staff', 'Data staff berhasil dihapus');
        } catch (Exception $e) {
            $this->redirect('/staff', 'Error: ' . $e->getMessage(), 'error');
        }
    }
}