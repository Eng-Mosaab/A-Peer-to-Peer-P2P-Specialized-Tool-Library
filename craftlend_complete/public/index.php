<?php
session_start();
require __DIR__ . '/../app/Helpers.php';
require __DIR__ . '/../app/Core/Database.php';
require __DIR__ . '/../app/Core/Controller.php';
require __DIR__ . '/../app/Core/Model.php';

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) return;
    $relative = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relative) . '.php';
    if (file_exists($file)) require $file;
});

$config = app_config();
$db = \App\Core\Database::getInstance($config['db']);

$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? null;

$routes = [
    'home' => [\App\Controllers\HomeController::class, 'index'],
    'auth' => [\App\Controllers\AuthController::class, 'login'],
    'dashboard' => [\App\Controllers\DashboardController::class, 'index'],
    'tools' => [\App\Controllers\ToolController::class, 'index'],
    'users' => [\App\Controllers\UserController::class, 'index'],
    'roles' => [\App\Controllers\RoleController::class, 'index'],
    'reservations' => [\App\Controllers\ReservationController::class, 'index'],
    'maintenance' => [\App\Controllers\MaintenanceController::class, 'index'],
    'notifications' => [\App\Controllers\NotificationController::class, 'index'],
    'reports' => [\App\Controllers\ReportController::class, 'index'],
    'lang' => [\App\Controllers\LanguageController::class, 'switch'],
    'theme' => [\App\Controllers\ThemeController::class, 'switch'],
];

if (!isset($routes[$page])) { http_response_code(404); die('Page not found'); }
[$controllerName, $defaultAction] = $routes[$page];
$controller = new $controllerName($db);
$method = $action ?? $defaultAction;
if (!method_exists($controller, $method)) { http_response_code(404); die('Action not found'); }
$controller->$method();
