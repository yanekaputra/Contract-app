<?php
require_once 'Database.php';

class Employee extends Database {
    protected $table = 'employees';
    
    public function generateEmployeeCode($type) {
        $prefix = $type == 'doctor' ? 'DR' : 'ST';
        $year = date('Y');
        
        // Get last employee code
        $sql = "SELECT employee_code FROM {$this->table} 
                WHERE employee_code LIKE :prefix 
                ORDER BY id DESC LIMIT 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['prefix' => $prefix . $year . '%']);
        $lastCode = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($lastCode) {
            $lastNumber = intval(substr($lastCode['employee_code'], -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
    
    public function getWithDetails($id) {
        $sql = "SELECT e.*, 
                CASE 
                    WHEN e.employee_type = 'doctor' THEN d.specialization
                    ELSE s.position
                END as position_info,
                u.unit_name as current_unit
                FROM {$this->table} e
                LEFT JOIN doctors d ON e.id = d.employee_id AND e.employee_type = 'doctor'
                LEFT JOIN staff s ON e.id = s.employee_id AND e.employee_type = 'staff'
                LEFT JOIN placement_history ph ON e.id = ph.employee_id AND ph.is_current = 1
                LEFT JOIN units u ON ph.unit_id = u.id
                WHERE e.id = :id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function search($keyword, $type = null, $unit = null) {
        $sql = "SELECT DISTINCT e.*, 
                CASE 
                    WHEN e.employee_type = 'doctor' THEN d.specialization
                    ELSE s.position
                END as position_info,
                u.unit_name as current_unit
                FROM {$this->table} e
                LEFT JOIN doctors d ON e.id = d.employee_id
                LEFT JOIN staff s ON e.id = s.employee_id
                LEFT JOIN placement_history ph ON e.id = ph.employee_id AND ph.is_current = 1
                LEFT JOIN units u ON ph.unit_id = u.id
                WHERE (e.employee_code LIKE :keyword OR e.full_name LIKE :keyword)";
        
        $params = ['keyword' => "%{$keyword}%"];
        
        if ($type) {
            $sql .= " AND e.employee_type = :type";
            $params['type'] = $type;
        }
        
        if ($unit) {
            $sql .= " AND u.id = :unit";
            $params['unit'] = $unit;
        }
        
        $sql .= " ORDER BY e.full_name";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}