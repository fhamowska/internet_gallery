<?php

namespace App\Controller;

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Twig\Environment;

class MainController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function index(): void
    {
        echo $this->twig->render('index.twig');
    }
}
