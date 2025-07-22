<?php
require_once 'BaseController.php';
require_once dirname(__DIR__) . '/Models/Notification.php';

class NotificationController extends BaseController {
    private $notificationModel;
    
    public function __construct() {
        $this->notificationModel = new Notification();
    }
    
    public function index() {
        $this->requireLogin();
        
        $notifications = $this->notificationModel->findAll([], 'created_at DESC', 50);
        $this->view('notifications/index', ['notifications' => $notifications]);
    }
    
    public function markAsRead($id) {
        $this->requireLogin();
        
        $this->notificationModel->markAsRead($id);
        $this->json(['status' => 'success']);
    }
    
    public function markAllAsRead() {
        $this->requireLogin();
        
        $this->notificationModel->markAllAsRead();
        $this->redirect('/notifications', 'Semua notifikasi telah ditandai sebagai dibaca');
    }
}