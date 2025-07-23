<?php
define('BASE_URL', 'http://localhost/contract-app');
define('UPLOAD_PATH', dirname(__DIR__) . '/public/uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// Email configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-email@gmail.com');
define('SMTP_PASSWORD', 'your-password');

// Notification settings
define('NOTIFY_BEFORE_DAYS', [90, 60, 30, 14, 7]);
