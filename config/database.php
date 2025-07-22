<?php
class DatabaseConfig {
    private static $host = 'localhost';
    private static $dbname = 'hospital_contract_db';
    private static $username = 'root';
    private static $password = '';
    
    public static function getConnection() {
        try {
            $conn = new PDO(
                "mysql:host=" . self::$host . ";dbname=" . self::$dbname,
                self::$username,
                self::$password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->exec("set names utf8");
            return $conn;
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}