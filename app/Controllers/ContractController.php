<?php
require_once 'BaseController.php';
require_once dirname(__DIR__) . '/Models/Contract.php';
require_once dirname(__DIR__) . '/Models/Employee.php';

class ContractController extends BaseController {
    private $contractModel;
    private $employeeModel;
    
    public function __construct() {
        $this->contractModel = new Contract();
        $this->employeeModel = new Employee();
    }
    
    public function index() {
        $this->requireLogin();
        
        $contracts = $this->contractModel->findAll([], 'end_date ASC');
        $this->view('contracts/index', ['contracts' => $contracts]);
    }
    
    public function create($employeeId = null) {
        $this->requireRole(['admin', 'hr']);
        
        $employee = null;
        if ($employeeId) {
            $employee = $this->employeeModel->findById($employeeId);
        }
        
        $employees = $this->employeeModel->findAll(['is_active' => 1], 'full_name ASC');
        
        $data = [
            'employee' => $employee,
            'employees' => $employees,
            'contractNumber' => $this->contractModel->generateContractNumber()
        ];
        
        $this->view('contracts/create', $data);
    }
    
    public function store() {
        $this->requireRole(['admin', 'hr']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/contracts');
        }
        
        try {
            $data = [
                'employee_id' => $_POST['employee_id'],
                'contract_number' => $_POST['contract_number'],
                'contract_type' => $_POST['contract_type'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'] ?: null,
                'salary_info' => $_POST['salary_info'] ?? null,
                'notes' => $_POST['notes'] ?? null,
                'status' => 'active',
                'created_by' => $_SESSION['user_id']
            ];
            
            // Upload contract file
            if (isset($_FILES['contract_file']) && $_FILES['contract_file']['error'] === 0) {
                $data['contract_file'] = $this->uploadFile($_FILES['contract_file'], 'contract');
            }
            
            $this->contractModel->create($data);
            
            $this->redirect('/contracts', 'Kontrak berhasil ditambahkan');
            
        } catch (Exception $e) {
            $this->redirect('/contracts/create', 'Error: ' . $e->getMessage(), 'error');
        }
    }
    
    public function edit($id) {
        $this->requireRole(['admin', 'hr']);
        
        $contract = $this->contractModel->findById($id);
        if (!$contract) {
            $this->redirect('/contracts', 'Kontrak tidak ditemukan', 'error');
        }
        
        $employee = $this->employeeModel->findById($contract['employee_id']);
        
        $data = [
            'contract' => $contract,
            'employee' => $employee
        ];
        
        $this->view('contracts/edit', $data);
    }
    
    public function update($id) {
        $this->requireRole(['admin', 'hr']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/contracts');
        }
        
        try {
            $contract = $this->contractModel->findById($id);
            
            $data = [
                'contract_type' => $_POST['contract_type'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'] ?: null,
                'salary_info' => $_POST['salary_info'] ?? null,
                'notes' => $_POST['notes'] ?? null,
                'status' => $_POST['status']
            ];
            
            // Upload contract file
            if (isset($_FILES['contract_file']) && $_FILES['contract_file']['error'] === 0) {
                $data['contract_file'] = $this->uploadFile($_FILES['contract_file'], 'contract', $contract['contract_file']);
            }
            
            $this->contractModel->update($id, $data);
            
            $this->redirect('/contracts', 'Kontrak berhasil diupdate');
            
        } catch (Exception $e) {
            $this->redirect("/contracts/edit/{$id}", 'Error: ' . $e->getMessage(), 'error');
        }
    }
    
    public function view($id) {
        $this->requireLogin();
        
        $contract = $this->contractModel->findById($id);
        if (!$contract) {
            $this->redirect('/contracts', 'Kontrak tidak ditemukan', 'error');
        }
        
        $employee = $this->employeeModel->getWithDetails($contract['employee_id']);
        
        $data = [
            'contract' => $contract,
            'employee' => $employee
        ];
        
        $this->view('contracts/view', $data);
    }
}