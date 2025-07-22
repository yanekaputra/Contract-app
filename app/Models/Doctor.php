<?php
require_once 'Database.php';

class Doctor extends Database {
    protected $table = 'doctors';
    
    public function getByEmployeeId($employeeId) {
        $sql = "SELECT * FROM {$this->table} WHERE employee_id = :employee_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['employee_id' => $employeeId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getAllWithExpiryStatus() {
        $sql = "SELECT d.*, e.employee_code, e.full_name, e.email, e.phone,
                DATEDIFF(d.str_expiry_date, CURDATE()) as str_days_remaining,
                DATEDIFF(d.sip_expiry_date, CURDATE()) as sip_days_remaining,
                CASE 
                    WHEN DATEDIFF(d.str_expiry_date, CURDATE()) <= 0 THEN 'expired'
                    WHEN DATEDIFF(d.str_expiry_date, CURDATE()) <= 30 THEN 'warning'
                    WHEN DATEDIFF(d.str_expiry_date, CURDATE()) <= 90 THEN 'notice'
                    ELSE 'active'
                END as str_status,
                CASE 
                    WHEN DATEDIFF(d.sip_expiry_date, CURDATE()) <= 0 THEN 'expired'
                    WHEN DATEDIFF(d.sip_expiry_date, CURDATE()) <= 30 THEN 'warning'
                    WHEN DATEDIFF(d.sip_expiry_date, CURDATE()) <= 90 THEN 'notice'
                    ELSE 'active'
                END as sip_status
                FROM {$this->table} d
                JOIN employees e ON d.employee_id = e.id
                WHERE e.is_active = 1
                ORDER BY e.full_name";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getExpiringDocuments($days = 30) {
        $sql = "SELECT d.*, e.employee_code, e.full_name, e.email,
                'str' as document_type, d.str_expiry_date as expiry_date,
                DATEDIFF(d.str_expiry_date, CURDATE()) as days_remaining
                FROM {$this->table} d
                JOIN employees e ON d.employee_id = e.id
                WHERE e.is_active = 1 
                AND d.str_expiry_date IS NOT NULL
                AND DATEDIFF(d.str_expiry_date, CURDATE()) BETWEEN 0 AND :days
                
                UNION ALL
                
                SELECT d.*, e.employee_code, e.full_name, e.email,
                'sip' as document_type, d.sip_expiry_date as expiry_date,
                DATEDIFF(d.sip_expiry_date, CURDATE()) as days_remaining
                FROM {$this->table} d
                JOIN employees e ON d.employee_id = e.id
                WHERE e.is_active = 1 
                AND d.sip_expiry_date IS NOT NULL
                AND DATEDIFF(d.sip_expiry_date, CURDATE()) BETWEEN 0 AND :days
                
                ORDER BY days_remaining";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['days' => $days]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}