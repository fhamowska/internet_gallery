<?php

use App\Controller\GenreController;
use App\Repository\GenreRepository;
use App\Service\GenreService;

require_once(__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

$genreRepository = new GenreRepository($pdo);
$genreService = new GenreService($genreRepository);
$genreController = new GenreController($genreService, $twig);

$error = null;
$name = $_POST['name'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $genreController->addGenre($name);
} else {
    echo $twig->render('add_genre.twig', ['error' => $error]);
}

