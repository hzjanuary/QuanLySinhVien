<?php
// public/index.php
// Nạp file autoload của Composer
session_start();
define('PROJECT_ROOT', dirname(__DIR__));
// Nạp file autoload của Composer
require_once PROJECT_ROOT . '/vendor/autoload.php';
require_once __DIR__ . '/../vendor/autoload.php';
use Hzjan\Bai01QuanlySv\Controllers\SinhvienController;
use Hzjan\Bai01QuanlySv\Controllers\UserController;
// Simple Router
$action = $_GET['action'] ?? 'index';
// Danh sách các action không yêu cầu đăng nhập
// $public_actions = [
//     'login',
//     'register',
//     'do_login',
//     'do_register'
// ];
// if (
//     !in_array($action, $public_actions) &&
//     !isset($_SESSION['user_id'])
// ) {
//     header('Location: index.php?action=login');
//     exit();
// }

$protected_actions = [
    'index',
    'edit',
    'update',
    'delete',
    'add',
    'dashboard'
];
if (
    in_array($action, $protected_actions) &&
    !isset($_SESSION['user_id'])
) {
    header('Location: index.php?action=login');
    exit();
}
$controller = new SinhvienController();

if (
    in_array($action, [
        'login',
        'register',
        'do_login',
        'do_register',
        'logout'
    ])
) {
    $controller = new UserController();
} else {
    $controller = new SinhvienController();
}
switch ($action) {
    case 'dashboard':
        $controller->dashboard();
        break;
    case 'add':
        $controller->add();
        break;
    // THÊM 2 CASE MỚI (bài 03)
    case 'edit':
        $controller->edit();
        break;
    case 'update':
        $controller->update();
        break;
    case 'delete':
        $controller->delete();
        break;
    // Các action của UserController
    case 'login':
        $controller->showLoginForm();
        break;
    case 'do_login':
        $controller->login();
        break;
    case 'register':
        $controller->showRegisterForm();
        break;
    case 'do_register':
        $controller->register();
        break;
    case 'logout':
        $controller->logout();
        break;
    case 'index':
    default:
        $controller->index();
        break;
}
?>