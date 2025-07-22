<?php
require_once 'Database.php';

class Unit extends Database {
    protected $table = 'units';
    
    public function getActive() {
        return $this->findAll(['is_active' => 1], 'unit_name ASC');
    }
    
    public function getWithEmployeeCount() {
        $sql = "SELECT u.*, COUNT(DISTINCT ph.employee_id) as employee_count
                FROM {$this->table} u
                LEFT JOIN placement_history ph ON u.id = ph.unit_id AND ph.is_current = 1
                WHERE u.is_active = 1
                GROUP BY u.id
                ORDER BY u.unit_name";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}