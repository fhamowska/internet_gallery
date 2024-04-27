<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

use App\Controller\GenreController;
use App\Repository\GenreRepository;
use App\Service\GenreService;

error_reporting(E_ALL);
require_once(__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

$genreRepository = new GenreRepository($pdo);
$genreService = new GenreService($genreRepository);
$genreController = new GenreController($genreService, $twig);
$genreController->listGenres();
