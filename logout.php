<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once (__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

use App\Controller\LoginController;
use App\Repository\AdminRepository;
use App\Service\AdminService;

$adminRepository = new AdminRepository($pdo);
$adminService = new AdminService($adminRepository);
$loginController = new LoginController($twig, $adminService);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $loginController->logout();
}
