<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

require_once(__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

use App\Controller\GenreController;
use App\Repository\GenreRepository;
use App\Service\GenreService;

$genreRepository = new GenreRepository($pdo);
$genreService = new GenreService($genreRepository);
$genreController = new GenreController($genreService, $twig);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $genreId = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';

    try {
        $genreController->editGenre((int)$genreId, $name);
    } catch (Exception $e) {
        $error = $e->getMessage();
        $genre = $genreService->getGenreById($genreId);
        echo $twig->render('edit_genre.twig', ['genre' => $genre, 'error' => $error]);
        exit();
    }
}

$genreId = $_GET['id'] ?? null;
$genre = $genreService->getGenreById($genreId);

echo $twig->render('edit_genre.twig', ['genre' => $genre]);
