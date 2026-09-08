<?php
session_start();

require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/DashboardController.php';
require_once __DIR__ . '/controllers/CategoryController.php';
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/SellerStoreController.php';

$page = $_GET['page'] ?? 'dashboard';

$publicPages = ['login'];

if (!in_array($page, $publicPages) && empty($_SESSION['admin_id'])) {
    header('Location: index.php?page=login');
    exit;
}

switch ($page) {

    case 'login':
        $auth = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth->login();
        } else {
            $auth->showLoginForm();
        }
        break;

    case 'logout':
        $auth = new AuthController();
        $auth->logout();
        break;

    case 'dashboard':
        $dashboard = new DashboardController();
        $dashboard->index();
        break;

    case 'categories':
        $categoryController = new CategoryController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryController->store();
        } elseif (isset($_GET['delete'])) {
            $categoryController->remove();
        } else {
            $categoryController->index();
        }
        break;

    default:
        http_response_code(404);
        echo "Page not found.";
        break;


        case 'products':
        $productController = new ProductController();
        if (isset($_GET['toggle'])) {
            $productController->toggleStatus();
        } elseif (isset($_GET['delete'])) {
            $productController->remove();
        } else {
            $productController->index();
        }
        break;
     
        case 'sellers':
        $sellerController = new SellerStoreController();
        if (isset($_GET['approve'])) {
            $sellerController->approve();
        } elseif (isset($_GET['suspend'])) {
            $sellerController->suspend();
        } else {
            $sellerController->index();
        }
        break;
}