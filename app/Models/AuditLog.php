<?php
require_once 'Database.php';

class AuditLog extends Database {
    protected $table = 'audit_logs';
    
    public function log($action, $tableName, $recordId, $oldValues = null, $newValues = null) {
        $data = [
            'user_id' => $_SESSION['user_id'] ?? null,
            'action' => $action,
            'table_name' => $tableName,
            'record_id' => $recordId,
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null
        ];
        
        return $this->create($data);
    }
    
    public function getByTable($tableName, $limit = 50) {
        $sql = "SELECT al.*, u.full_name as user_name 
                FROM {$this->table} al
                LEFT JOIN users u ON al.user_id = u.id
                WHERE al.table_name = :table_name
                ORDER BY al.created_at DESC
                LIMIT :limit";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':table_name', $tableName);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
