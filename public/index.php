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
use Hzjan\Bai01QuanlySv\Controllers\PageController;
// Simple Router
$action = $_GET['action'] ?? 'index';

$public_actions = ['login', 'register', 'do_login', 'do_register', 'contact', 'submit_contact'];

$protected_actions = [
    'index',
    'edit',
    'update',
    'delete',
    'add',
    'dashboard',
    'detail'
];
if (
    in_array($action, $protected_actions) &&
    !isset($_SESSION['user_id'])
) {
    header('Location: index.php?action=login');
    exit();
}
$controller = new SinhvienController();

if (in_array($action, ['contact', 'submit_contact'])) {
    $controller = new PageController();
} elseif (
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
    case 'contact':
        $controller->showContactForm();
        break;
    case 'submit_contact':
        $controller->submitContact();
        break;
    case 'detail':
        $controller->detail();
        break;
    case 'index':
    default:
        $controller->index();
        break;
}
?>