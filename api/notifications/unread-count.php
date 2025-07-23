<?php
session_start();
require_once '../config/config.php';
require_once '../app/Models/Notification.php';

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$notificationModel = new Notification();
$count = $notificationModel->count(['is_read' => 0]);

header('Content-Type: application/json');
echo json_encode(['count' => $count]);
