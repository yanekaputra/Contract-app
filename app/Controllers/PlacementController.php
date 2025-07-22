<?php
require_once 'BaseController.php';
require_once dirname(__DIR__) . '/Models/Placement.php';
require_once dirname(__DIR__) . '/Models/Employee.php';
require_once dirname(__DIR__) . '/Models/Unit.php';

class PlacementController extends BaseController {
    private $placementModel;
    private $employeeModel;
    private $unitModel;
    
    public function __construct() {
        $this->placementModel = new Placement();
        $this->employeeModel = new Employee();
        $this->unitModel = new Unit();
    }
    
    public function index() {
        $this->requireLogin();
        
        $units = $this->unitModel->getWithEmployeeCount();
        $this->view('placements/index', ['units' => $units]);
    }
    
    public function assign() {
        $this->requireRole(['admin', 'hr']);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/placements');
        }
        
        try {
            $data = [
                'placement_reason' => $_POST['placement_reason'],
                'sk_number' => $_POST['sk_number'] ?? null,
                'notes' => $_POST['notes'] ?? null,
                'start_date' => $_POST['start_date'],
                'created_by' => $_SESSION['user_id']
            ];
            
            // Upload SK file if exists
            if (isset($_FILES['sk_file']) && $_FILES['sk_file']['error'] === 0) {
                $data['sk_file'] = $this->uploadFile($_FILES['sk_file'], 'placement');
            }
            
            $this->placementModel->assignToUnit(
                $_POST['employee_id'],
                $_POST['unit_id'],
                $data
            );
            
            $this->redirect('/placements', 'Penempatan berhasil dilakukan');
            
        } catch (Exception $e) {
            $this->redirect('/placements', 'Error: ' . $e->getMessage(), 'error');
        }
    }
    
    public function history($employeeId = null) {
        $this->requireLogin();
        
        if ($employeeId) {
            $employee = $this->employeeModel->getWithDetails($employeeId);
            if (!$employee) {
                $this->json(['error' => 'Employee not found'], 404);
            }
            
            $history = $this->placementModel->getHistory($employeeId);
            $this->json($history);
        } else {
            // Show all placement history
            $this->view('placements/history');
        }
    }
    
    public function unitDetail($unitId) {
        $this->requireLogin();
        
        $unit = $this->unitModel->findById($unitId);
        if (!$unit) {
            $this->redirect('/placements', 'Unit tidak ditemukan', 'error');
        }
        
        $employees = $this->placementModel->getByUnit($unitId, true);
        
        $data = [
            'unit' => $unit,
            'employees' => $employees
        ];
        
        $this->view('placements/unit-detail', $data);
    }
}