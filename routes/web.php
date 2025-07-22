<?php
$request = $_SERVER['REQUEST_URI'];
$request = str_replace('/hospital-contract-app', '', $request);
$request = strtok($request, '?');

// Remove trailing slash
$request = rtrim($request, '/');
if (empty($request)) {
    $request = '/';
}

// Define routes
$routes = [
    '/' => ['controller' => 'DashboardController', 'method' => 'index'],
    '/login' => ['controller' => 'AuthController', 'method' => 'login'],
    '/authenticate' => ['controller' => 'AuthController', 'method' => 'authenticate'],
    '/logout' => ['controller' => 'AuthController', 'method' => 'logout'],
    
    // Dashboard
    '/dashboard' => ['controller' => 'DashboardController', 'method' => 'index'],
    '/api/check-expiry' => ['controller' => 'DashboardController', 'method' => 'checkExpiry'],
    
    // Doctors
    '/doctors' => ['controller' => 'DoctorController', 'method' => 'index'],
    '/doctors/create' => ['controller' => 'DoctorController', 'method' => 'create'],
    '/doctors/store' => ['controller' => 'DoctorController', 'method' => 'store'],
    
    // Staff
    '/staff' => ['controller' => 'StaffController', 'method' => 'index'],
    '/staff/create' => ['controller' => 'StaffController', 'method' => 'create'],
    '/staff/store' => ['controller' => 'StaffController', 'method' => 'store'],
    
    // Contracts
    '/contracts' => ['controller' => 'ContractController', 'method' => 'index'],
    '/contracts/create' => ['controller' => 'ContractController', 'method' => 'create'],
    '/contracts/store' => ['controller' => 'ContractController', 'method' => 'store'],
    
    // Placements
    '/placements' => ['controller' => 'PlacementController', 'method' => 'index'],
    '/placements/assign' => ['controller' => 'PlacementController', 'method' => 'assign'],
    '/placements/history' => ['controller' => 'PlacementController', 'method' => 'history'],
    
    // Notifications
    '/notifications' => ['controller' => 'NotificationController', 'method' => 'index'],
    '/notifications/mark-all-read' => ['controller' => 'NotificationController', 'method' => 'markAllAsRead'],
    
    // Reports
    '/reports/expired-documents' => ['controller' => 'ReportController', 'method' => 'expiredDocuments'],
    '/reports/export/expired-documents' => ['controller' => 'ReportController', 'method' => 'exportExpiredDocuments'],
];

// Check for dynamic routes
$routeFound = false;

// Pattern matching for routes with parameters
$patterns = [
    '#^/doctors/edit/(\d+)$#' => ['controller' => 'DoctorController', 'method' => 'edit'],
    '#^/doctors/update/(\d+)$#' => ['controller' => 'DoctorController', 'method' => 'update'],
    '#^/doctors/view/(\d+)$#' => ['controller' => 'DoctorController', 'method' => 'view'],
    '#^/doctors/delete/(\d+)$#' => ['controller' => 'DoctorController', 'method' => 'delete'],
    
    '#^/staff/edit/(\d+)$#' => ['controller' => 'StaffController', 'method' => 'edit'],
    '#^/staff/update/(\d+)$#' => ['controller' => 'StaffController', 'method' => 'update'],
    '#^/staff/view/(\d+)$#' => ['controller' => 'StaffController', 'method' => 'view'],
    '#^/staff/delete/(\d+)$#' => ['controller' => 'StaffController', 'method' => 'delete'],
    
    '#^/contracts/edit/(\d+)$#' => ['controller' => 'ContractController', 'method' => 'edit'],
    '#^/contracts/update/(\d+)$#' => ['controller' => 'ContractController', 'method' => 'update'],
    '#^/contracts/view/(\d+)$#' => ['controller' => 'ContractController', 'method' => 'view'],
    '#^/contracts/create/(\d+)$#' => ['controller' => 'ContractController', 'method' => 'create'],
    
    '#^/placements/unit/(\d+)$#' => ['controller' => 'PlacementController', 'method' => 'unitDetail'],
    '#^/api/placement-history/(\d+)$#' => ['controller' => 'PlacementController', 'method' => 'history'],
    
    '#^/notifications/read/(\d+)$#' => ['controller' => 'NotificationController', 'method' => 'markAsRead'],
];

foreach ($patterns as $pattern => $route) {
    if (preg_match($pattern, $request, $matches)) {
        $controllerName = $route['controller'];
        $methodName = $route['method'];
        $param = $matches[1];
        $routeFound = true;
        break;
    }
}

// Check static routes
if (!$routeFound && isset($routes[$request])) {
    $controllerName = $routes[$request]['controller'];
    $methodName = $routes[$request]['method'];
    $param = null;
    $routeFound = true;
}

// Execute route
if ($routeFound) {
    require_once dirname(__DIR__) . '/app/Controllers/' . $controllerName . '.php';
    $controller = new $controllerName();
    
    if ($param !== null) {
        $controller->$methodName($param);
    } else {
        $controller->$methodName();
    }
} else {
    // 404 Not Found
    http_response_code(404);
    echo "404 - Page not found";
}