<?php

use App\Controller\LoginController;
use App\Repository\AdminRepository;
use App\Service\AdminService;

session_start();

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
    header("Location: admin.php");
    exit();
}

require_once (__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

$adminRepository = new AdminRepository($pdo);
$adminService = new AdminService($adminRepository);

$loginController = new LoginController($twig, $adminService);
$loginController->login();
