<?php
require_once 'BaseController.php';
require_once dirname(__DIR__) . '/Models/Employee.php';
require_once dirname(__DIR__) . '/Models/Doctor.php';
require_once dirname(__DIR__) . '/Models/Staff.php';
require_once dirname(__DIR__) . '/Models/Contract.php';
require_once dirname(__DIR__) . '/Models/Notification.php';
require_once dirname(__DIR__) . '/Models/Unit.php';

class DashboardController extends BaseController {
    private $employeeModel;
    private $doctorModel;
    private $staffModel;
    private $contractModel;
    private $notificationModel;
    private $unitModel;
    
    public function __construct() {
        $this->employeeModel = new Employee();
        $this->doctorModel = new Doctor();
        $this->staffModel = new Staff();
        $this->contractModel = new Contract();
        $this->notificationModel = new Notification();
        $this->unitModel = new Unit();
    }
    
    public function index() {
        $this->requireLogin();
        
        // Get statistics
        $data = [
            'total_employees' => $this->employeeModel->count(['is_active' => 1]),
            'total_doctors' => $this->employeeModel->count(['employee_type' => 'doctor', 'is_active' => 1]),
            'total_staff' => $this->employeeModel->count(['employee_type' => 'staff', 'is_active' => 1]),
            'expiring_documents' => $this->getExpiringDocumentsCount(),
            'recent_notifications' => $this->notificationModel->getUnread(5),
            'units_data' => $this->unitModel->getWithEmployeeCount(),
            'expiring_soon' => $this->getExpiringSoon()
        ];
        
        $this->view('dashboard/index', $data);
    }
    
    private function getExpiringDocumentsCount() {
        $doctorStr = count($this->doctorModel->getExpiringDocuments(30));
        $staffStr = count($this->staffModel->getExpiringDocuments(30));
        $contracts = count($this->contractModel->getExpiringContracts(30));
        
        return $doctorStr + $staffStr + $contracts;
    }
    
    private function getExpiringSoon() {
        $results = [];
        
        // Get doctor documents
        $doctorDocs = $this->doctorModel->getExpiringDocuments(7);
        foreach ($doctorDocs as $doc) {
            $doc['category'] = 'Dokter';
            $results[] = $doc;
        }
        
        // Get staff documents
        $staffDocs = $this->staffModel->getExpiringDocuments(7);
        foreach ($staffDocs as $doc) {
            $doc['category'] = 'Staff';
            $results[] = $doc;
        }
        
        // Get contracts
        $contracts = $this->contractModel->getExpiringContracts(7);
        foreach ($contracts as $contract) {
            $contract['document_type'] = 'contract';
            $contract['category'] = $contract['employee_type'] == 'doctor' ? 'Dokter' : 'Staff';
            $results[] = $contract;
        }
        
        // Sort by days remaining
        usort($results, function($a, $b) {
            return $a['days_remaining'] - $b['days_remaining'];
        });
        
        return array_slice($results, 0, 10);
    }
    
    public function checkExpiry() {
        $this->requireLogin();
        
        $expiring = [];
        
        // Check doctor documents
        $doctorDocs = $this->doctorModel->getExpiringDocuments(30);
        foreach ($doctorDocs as $doc) {
            $this->notificationModel->createExpiryNotification(
                $doc['document_type'] . '_expiry',
                $doc['employee_id'],
                $doc['expiry_date'],
                $doc['days_remaining']
            );
            $expiring[] = $doc;
        }
        
        // Check staff documents
        $staffDocs = $this->staffModel->getExpiringDocuments(30);
        foreach ($staffDocs as $doc) {
            $this->notificationModel->createExpiryNotification(
                $doc['document_type'] . '_expiry',
                $doc['employee_id'],
                $doc['expiry_date'],
                $doc['days_remaining']
            );
            $expiring[] = $doc;
        }
        
        // Check contracts
        $contracts = $this->contractModel->getExpiringContracts(30);
        foreach ($contracts as $contract) {
            $this->notificationModel->createExpiryNotification(
                'contract_expiry',
                $contract['employee_id'],
                $contract['end_date'],
                $contract['days_remaining']
            );
            $expiring[] = $contract;
        }
        
        // Update expired contracts status
        $this->contractModel->updateExpiredContracts();
        
        $this->json(['status' => 'success', 'expired' => $expiring]);
    }
}
