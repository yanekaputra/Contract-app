<?php
require_once 'Database.php';

class User extends Database {
    protected $table = 'users';
    
    public function authenticate($username, $password) {
        $sql = "SELECT * FROM {$this->table} WHERE username = :username AND is_active = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            // Update last login
            $this->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
            return $user;
        }
        
        return false;
    }
    
    public function changePassword($userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->update($userId, ['password' => $hashedPassword]);
    }
}