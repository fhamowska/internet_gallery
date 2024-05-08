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
    try {
        $genreController->addGenre($name);
        header("Location: genres_admin.php");
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

echo $twig->render('genre_add.twig', ['error' => $error]);
