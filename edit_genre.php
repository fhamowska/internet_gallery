<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

use App\Controller\GenreController;
use App\Repository\GenreRepository;
use App\Service\GenreService;

require_once(__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

$genreRepository = new GenreRepository($pdo);
$genreService = new GenreService($genreRepository);
$genreController = new GenreController($genreService, $twig);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $genreId = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';

    $genreController->editGenre((int)$genreId, $name);
}

$genreId = $_GET['id'] ?? null;
$genre = $genreService->getGenreById($genreId);

echo $twig->render('edit_genre.twig', ['genre' => $genre]);
