<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once (__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

use App\Controller\AdminController;
use App\Factory\ArtworkServiceFactory;
use App\Repository\GenreRepository;
use App\Service\GenreService;

$genreRepository = new GenreRepository($pdo);
$genreService = new GenreService($genreRepository);

$artworkService = ArtworkServiceFactory::create($pdo);

$adminController = new AdminController($twig, $artworkService, $genreService);
$adminController->index();
