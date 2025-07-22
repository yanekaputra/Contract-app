<?php
session_start();

abstract class BaseController {
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }
    
    protected function requireRole($roles) {
        $this->requireLogin();
        
        if (!in_array($_SESSION['user_role'], (array)$roles)) {
            $_SESSION['error'] = 'Anda tidak memiliki akses ke halaman ini';
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }
    }
    
    protected function redirect($path, $message = null, $type = 'success') {
        if ($message) {
            $_SESSION[$type] = $message;
        }
        header('Location: ' . BASE_URL . $path);
        exit;
    }
    
    protected function view($viewPath, $data = []) {
        extract($data);
        
        $viewFile = dirname(__DIR__) . '/Views/' . $viewPath . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View file not found: {$viewFile}");
        }
    }
    
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function uploadFile($file, $type, $oldFile = null) {
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return $oldFile;
        }
        
        $allowedTypes = [
            'str' => ['pdf', 'jpg', 'jpeg', 'png'],
            'sip' => ['pdf', 'jpg', 'jpeg', 'png'],
            'contract' => ['pdf', 'doc', 'docx'],
            'photo' => ['jpg', 'jpeg', 'png']
        ];
        
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if (!in_array($extension, $allowedTypes[$type] ?? [])) {
            throw new Exception('Tipe file tidak diizinkan');
        }
        
        if ($file['size'] > MAX_FILE_SIZE) {
            throw new Exception('Ukuran file terlalu besar (max 5MB)');
        }
        
        $fileName = $type . '_' . time() . '_' . uniqid() . '.' . $extension;
        $uploadPath = UPLOAD_PATH . $type . '/' . $fileName;
        
        if (!is_dir(dirname($uploadPath))) {
            mkdir(dirname($uploadPath), 0777, true);
        }
        
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Delete old file if exists
            if ($oldFile && file_exists(UPLOAD_PATH . $type . '/' . $oldFile)) {
                unlink(UPLOAD_PATH . $type . '/' . $oldFile);
            }
            return $fileName;
        }
        
        throw new Exception('Gagal upload file');
    }
}