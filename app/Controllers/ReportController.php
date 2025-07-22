<?php
require_once 'BaseController.php';
require_once dirname(__DIR__) . '/Models/Doctor.php';
require_once dirname(__DIR__) . '/Models/Staff.php';
require_once dirname(__DIR__) . '/Models/Contract.php';

class ReportController extends BaseController {
    private $doctorModel;
    private $staffModel;
    private $contractModel;
    
    public function __construct() {
        $this->doctorModel = new Doctor();
        $this->staffModel = new Staff();
        $this->contractModel = new Contract();
    }
    
    public function expiredDocuments() {
        $this->requireLogin();
        
        $days = $_GET['days'] ?? 30;
        
        $data = [
            'doctorDocs' => $this->doctorModel->getExpiringDocuments($days),
            'staffDocs' => $this->staffModel->getExpiringDocuments($days),
            'contracts' => $this->contractModel->getExpiringContracts($days),
            'days' => $days
        ];
        
        $this->view('reports/expired-documents', $data);
    }
    
    public function exportExpiredDocuments() {
        $this->requireLogin();
        
        $days = $_GET['days'] ?? 30;
        
        // Get data
        $doctorDocs = $this->doctorModel->getExpiringDocuments($days);
        $staffDocs = $this->staffModel->getExpiringDocuments($days);
        $contracts = $this->contractModel->getExpiringContracts($days);
        
        // Create CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="expired-documents-' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        
        // Header
        fputcsv($output, ['Nama', 'NIP', 'Tipe Dokumen', 'Tanggal Kadaluarsa', 'Sisa Hari', 'Status']);
        
        // Doctor documents
        foreach ($doctorDocs as $doc) {
            fputcsv($output, [
                $doc['full_name'],
                $doc['employee_code'],
                strtoupper($doc['document_type']),
                date('d/m/Y', strtotime($doc['expiry_date'])),
                $doc['days_remaining'],
                $doc['days_remaining'] <= 0 ? 'Expired' : 'Akan Expired'
            ]);
        }
        
        // Staff documents
        foreach ($staffDocs as $doc) {
            fputcsv($output, [
                $doc['full_name'],
                $doc['employee_code'],
                strtoupper($doc['document_type']),
                date('d/m/Y', strtotime($doc['expiry_date'])),
                $doc['days_remaining'],
                $doc['days_remaining'] <= 0 ? 'Expired' : 'Akan Expired'
            ]);
        }
        
        // Contracts
        foreach ($contracts as $contract) {
            fputcsv($output, [
                $contract['full_name'],
                $contract['employee_code'],
                'KONTRAK',
                date('d/m/Y', strtotime($contract['end_date'])),
                $contract['days_remaining'],
                $contract['days_remaining'] <= 0 ? 'Expired' : 'Akan Expired'
            ]);
        }
        
        fclose($output);
        exit;
    }
}