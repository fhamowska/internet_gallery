<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once (__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

use App\Controller\AdminController;
use App\Factory\ArtworkServiceFactory;
use App\Repository\GenreRepository;
use App\Service\GenreService;

$artworkService = ArtworkServiceFactory::create($pdo);
$genreRepository = new GenreRepository($pdo);
$genreService = new GenreService($genreRepository);

$adminController = new AdminController($twig, $artworkService, $genreService);
$adminController->index();
