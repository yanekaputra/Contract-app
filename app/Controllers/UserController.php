<?php
require_once 'BaseController.php';
require_once dirname(__DIR__) . '/Models/User.php';

class UserController extends BaseController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function index() {
        $this->requireRole('admin');
        
        $users = $this->userModel->findAll([], 'created_at DESC');
        $this->view('users/index', ['users' => $users]);
    }
    
    public function create() {
        $this->requireRole('admin');
        $this->view('users/create');
    }
    
    public function store() {
        $this->requireRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/users');
        }
        
        try {
            $data = [
                'username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'email' => $_POST['email'],
                'full_name' => $_POST['full_name'],
                'role' => $_POST['role'],
                'is_active' => 1
            ];
            
            $this->userModel->create($data);
            $this->redirect('/users', 'User berhasil ditambahkan');
            
        } catch (Exception $e) {
            $this->redirect('/users/create', 'Error: ' . $e->getMessage(), 'error');
        }
    }
    
    public function edit($id) {
        $this->requireRole('admin');
        
        $user = $this->userModel->findById($id);
        if (!$user) {
            $this->redirect('/users', 'User tidak ditemukan', 'error');
        }
        
        $this->view('users/edit', ['user' => $user]);
    }
    
    public function update($id) {
        $this->requireRole('admin');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/users');
        }
        
        try {
            $data = [
                'email' => $_POST['email'],
                'full_name' => $_POST['full_name'],
                'role' => $_POST['role'],
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];
            
            // Update password if provided
            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }
            
            $this->userModel->update($id, $data);
            $this->redirect('/users', 'User berhasil diupdate');
            
        } catch (Exception $e) {
            $this->redirect("/users/edit/{$id}", 'Error: ' . $e->getMessage(), 'error');
        }
    }
    
    public function delete($id) {
        $this->requireRole('admin');
        
        if ($id == $_SESSION['user_id']) {
            $this->redirect('/users', 'Tidak dapat menghapus user yang sedang login', 'error');
        }
        
        try {
            $this->userModel->delete($id);
            $this->redirect('/users', 'User berhasil dihapus');
        } catch (Exception $e) {
            $this->redirect('/users', 'Error: ' . $e->getMessage(), 'error');
        }
    }
    
    public function profile() {
        $this->requireLogin();
        
        $user = $this->userModel->findById($_SESSION['user_id']);
        $this->view('users/profile', ['user' => $user]);
    }
    
    public function changePassword() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userModel->findById($_SESSION['user_id']);
            
            if (!password_verify($_POST['current_password'], $user['password'])) {
                $this->redirect('/change-password', 'Password lama salah', 'error');
            }
            
            if ($_POST['new_password'] !== $_POST['confirm_password']) {
                $this->redirect('/change-password', 'Password baru tidak cocok', 'error');
            }
            
            try {
                $this->userModel->changePassword($_SESSION['user_id'], $_POST['new_password']);
                $this->redirect('/dashboard', 'Password berhasil diubah');
            } catch (Exception $e) {
                $this->redirect('/change-password', 'Error: ' . $e->getMessage(), 'error');
            }
        } else {
            $this->view('users/change-password');
        }
    }
}
