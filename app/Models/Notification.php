<?php
require_once 'Database.php';

class Notification extends Database {
    protected $table = 'notifications';
    
    public function getUnread($limit = 10) {
        $sql = "SELECT n.*, e.employee_code, e.full_name 
                FROM {$this->table} n
                JOIN employees e ON n.employee_id = e.id
                WHERE n.is_read = 0
                ORDER BY n.created_at DESC
                LIMIT :limit";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function markAsRead($id) {
        return $this->update($id, ['is_read' => 1]);
    }
    
    public function markAllAsRead() {
        $sql = "UPDATE {$this->table} SET is_read = 1 WHERE is_read = 0";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute();
    }
    
    public function createExpiryNotification($type, $employeeId, $expiryDate, $daysRemaining) {
        $titles = [
            'str_expiry' => 'STR Akan Kadaluarsa',
            'sip_expiry' => 'SIP Akan Kadaluarsa',
            'contract_expiry' => 'Kontrak Akan Berakhir'
        ];
        
        $data = [
            'type' => $type,
            'employee_id' => $employeeId,
            'title' => $titles[$type] ?? 'Dokumen Akan Kadaluarsa',
            'message' => "Dokumen akan kadaluarsa pada tanggal " . date('d/m/Y', strtotime($expiryDate)),
            'expiry_date' => $expiryDate,
            'days_before_expiry' => $daysRemaining
        ];
        
        // Check if notification already exists
        $sql = "SELECT id FROM {$this->table} 
                WHERE type = :type 
                AND employee_id = :employee_id 
                AND expiry_date = :expiry_date
                AND DATE(created_at) = CURDATE()";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'type' => $type,
            'employee_id' => $employeeId,
            'expiry_date' => $expiryDate
        ]);
        
        if (!$stmt->fetch()) {
            return $this->create($data);
        }
        
        return false;
    }
}