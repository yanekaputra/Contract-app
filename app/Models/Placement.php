<?php
require_once 'Database.php';

class Placement extends Database {
    protected $table = 'placement_history';
    
    public function getCurrentPlacement($employeeId) {
        $sql = "SELECT ph.*, u.unit_name, u.unit_code 
                FROM {$this->table} ph
                JOIN units u ON ph.unit_id = u.id
                WHERE ph.employee_id = :employee_id 
                AND ph.is_current = 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['employee_id' => $employeeId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getHistory($employeeId) {
        $sql = "SELECT ph.*, u.unit_name, u.unit_code 
                FROM {$this->table} ph
                JOIN units u ON ph.unit_id = u.id
                WHERE ph.employee_id = :employee_id 
                ORDER BY ph.start_date DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['employee_id' => $employeeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function assignToUnit($employeeId, $unitId, $data) {
        // End current placement
        $sql = "UPDATE {$this->table} 
                SET is_current = 0, end_date = :end_date 
                WHERE employee_id = :employee_id AND is_current = 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'employee_id' => $employeeId,
            'end_date' => date('Y-m-d')
        ]);
        
        // Create new placement
        $data['employee_id'] = $employeeId;
        $data['unit_id'] = $unitId;
        $data['is_current'] = 1;
        $data['start_date'] = $data['start_date'] ?? date('Y-m-d');
        
        return $this->create($data);
    }
    
    public function getByUnit($unitId, $currentOnly = true) {
        $sql = "SELECT ph.*, e.employee_code, e.full_name, e.employee_type,
                CASE 
                    WHEN e.employee_type = 'doctor' THEN d.specialization
                    ELSE s.position
                END as position_info
                FROM {$this->table} ph
                JOIN employees e ON ph.employee_id = e.id
                LEFT JOIN doctors d ON e.id = d.employee_id
                LEFT JOIN staff s ON e.id = s.employee_id
                WHERE ph.unit_id = :unit_id";
        
        if ($currentOnly) {
            $sql .= " AND ph.is_current = 1";
        }
        
        $sql .= " ORDER BY ph.start_date DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['unit_id' => $unitId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}