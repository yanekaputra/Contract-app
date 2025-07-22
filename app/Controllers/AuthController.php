<?php
require_once 'BaseController.php';
require_once dirname(__DIR__) . '/Models/User.php';

class AuthController extends BaseController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function login() {
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        $this->view('auth/login');
    }
    
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
        }
        
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $user = $this->userModel->authenticate($username, $password);
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['username'] = $user['username'];
            
            $this->redirect('/dashboard', 'Login berhasil');
        } else {
            $this->redirect('/login', 'Username atau password salah', 'error');
        }
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('/login', 'Logout berhasil');
    }
}
