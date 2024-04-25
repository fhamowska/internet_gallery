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
    $error = $genreController->addGenre($name);
    if ($error === null) {
        header("Location: genres.php");
        exit();
    }
}

echo $twig->render('add_genre.twig', ['error' => $error]);
?>
