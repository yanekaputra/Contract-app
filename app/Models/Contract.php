<?php
require_once 'Database.php';

class Contract extends Database {
    protected $table = 'contracts';
    
    public function getActiveByEmployeeId($employeeId) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE employee_id = :employee_id 
                AND status = 'active' 
                ORDER BY start_date DESC 
                LIMIT 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['employee_id' => $employeeId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getAllByEmployeeId($employeeId) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE employee_id = :employee_id 
                ORDER BY start_date DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['employee_id' => $employeeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getExpiringContracts($days = 30) {
        $sql = "SELECT c.*, e.employee_code, e.full_name, e.email, e.employee_type,
                DATEDIFF(c.end_date, CURDATE()) as days_remaining
                FROM {$this->table} c
                JOIN employees e ON c.employee_id = e.id
                WHERE e.is_active = 1 
                AND c.status = 'active'
                AND c.end_date IS NOT NULL
                AND DATEDIFF(c.end_date, CURDATE()) BETWEEN 0 AND :days
                ORDER BY days_remaining";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['days' => $days]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function updateExpiredContracts() {
        $sql = "UPDATE {$this->table} 
                SET status = 'expired' 
                WHERE status = 'active' 
                AND end_date IS NOT NULL 
                AND end_date < CURDATE()";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }
    
    public function generateContractNumber() {
        $year = date('Y');
        $month = date('m');
        
        $sql = "SELECT contract_number FROM {$this->table} 
                WHERE contract_number LIKE :prefix 
                ORDER BY id DESC LIMIT 1";
        
        $prefix = "CTR/{$year}/{$month}/";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['prefix' => $prefix . '%']);
        $lastContract = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($lastContract) {
            $lastNumber = intval(substr($lastContract['contract_number'], -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
