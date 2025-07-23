<?php
class FileUpload {
    private static $allowedTypes = [
        'str' => ['pdf', 'jpg', 'jpeg', 'png'],
        'sip' => ['pdf', 'jpg', 'jpeg', 'png'],
        'contract' => ['pdf', 'doc', 'docx'],
        'photo' => ['jpg', 'jpeg', 'png'],
        'placement' => ['pdf']
    ];
    
    public static function upload($file, $type, $oldFile = null) {
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            return $oldFile;
        }
        
        // Validate file type
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, self::$allowedTypes[$type] ?? [])) {
            throw new Exception('Tipe file tidak diizinkan');
        }
        
        // Validate file size
        if ($file['size'] > MAX_FILE_SIZE) {
            throw new Exception('Ukuran file terlalu besar (max 5MB)');
        }
        
        // Generate unique filename
        $fileName = $type . '_' . time() . '_' . uniqid() . '.' . $extension;
        $uploadDir = UPLOAD_PATH . $type . '/';
        $uploadPath = $uploadDir . $fileName;
        
        // Create directory if not exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Upload file
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Delete old file if exists
            if ($oldFile && file_exists($uploadDir . $oldFile)) {
                unlink($uploadDir . $oldFile);
            }
            return $fileName;
        }
        
        throw new Exception('Gagal upload file');
    }
    
    public static function delete($fileName, $type) {
        $filePath = UPLOAD_PATH . $type . '/' . $fileName;
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }
}