<?php

namespace App\Controller;

use App\Service\AdminService;
use Twig\Environment;

class LoginController
{
    private Environment $twig;
    private AdminService $adminService;

    public function __construct(Environment $twig, AdminService $adminService)
    {
        $this->twig = $twig;
        $this->adminService = $adminService;
    }

    public function login()
    {
        session_start();

        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
            header("Location: admin.php");
            exit();
        }

        $error = null;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            var_dump($username, $password);

            $admin = $this->adminService->findByUsername($username);
            var_dump($admin->getPassword());

            if ($admin && ($password === $admin->getPassword())) {
                $_SESSION['admin_logged_in'] = true;

                header("Location: admin.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        }

        echo $this->twig->render('login.twig', ['error' => $error]);
    }
}
