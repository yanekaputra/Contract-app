<?php
require_once 'Database.php';

class Staff extends Database {
    protected $table = 'staff';
    
    public function getByEmployeeId($employeeId) {
        $sql = "SELECT * FROM {$this->table} WHERE employee_id = :employee_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['employee_id' => $employeeId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getAllWithExpiryStatus() {
        $sql = "SELECT s.*, e.employee_code, e.full_name, e.email, e.phone,
                DATEDIFF(s.str_expiry_date, CURDATE()) as str_days_remaining,
                DATEDIFF(s.sip_expiry_date, CURDATE()) as sip_days_remaining,
                CASE 
                    WHEN s.has_str = 0 THEN NULL
                    WHEN DATEDIFF(s.str_expiry_date, CURDATE()) <= 0 THEN 'expired'
                    WHEN DATEDIFF(s.str_expiry_date, CURDATE()) <= 30 THEN 'warning'
                    WHEN DATEDIFF(s.str_expiry_date, CURDATE()) <= 90 THEN 'notice'
                    ELSE 'active'
                END as str_status,
                CASE 
                    WHEN s.has_sip = 0 THEN NULL
                    WHEN DATEDIFF(s.sip_expiry_date, CURDATE()) <= 0 THEN 'expired'
                    WHEN DATEDIFF(s.sip_expiry_date, CURDATE()) <= 30 THEN 'warning'
                    WHEN DATEDIFF(s.sip_expiry_date, CURDATE()) <= 90 THEN 'notice'
                    ELSE 'active'
                END as sip_status
                FROM {$this->table} s
                JOIN employees e ON s.employee_id = e.id
                WHERE e.is_active = 1
                ORDER BY e.full_name";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getExpiringDocuments($days = 30) {
        $sql = "SELECT s.*, e.employee_code, e.full_name, e.email,
                'str' as document_type, s.str_expiry_date as expiry_date,
                DATEDIFF(s.str_expiry_date, CURDATE()) as days_remaining
                FROM {$this->table} s
                JOIN employees e ON s.employee_id = e.id
                WHERE e.is_active = 1 
                AND s.has_str = 1
                AND s.str_expiry_date IS NOT NULL
                AND DATEDIFF(s.str_expiry_date, CURDATE()) BETWEEN 0 AND :days
                
                UNION ALL
                
                SELECT s.*, e.employee_code, e.full_name, e.email,
                'sip' as document_type, s.sip_expiry_date as expiry_date,
                DATEDIFF(s.sip_expiry_date, CURDATE()) as days_remaining
                FROM {$this->table} s
                JOIN employees e ON s.employee_id = e.id
                WHERE e.is_active = 1 
                AND s.has_sip = 1
                AND s.sip_expiry_date IS NOT NULL
                AND DATEDIFF(s.sip_expiry_date, CURDATE()) BETWEEN 0 AND :days
                
                ORDER BY days_remaining";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['days' => $days]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}