<?php
use App\Repository\GenreRepository;
use App\Service\GenreService;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

$genreRepository = new GenreRepository($pdo);
$genreService = new GenreService($genreRepository);

$error = null;
$genreId = $_GET['id'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $genreId = $_GET['id'];
    try {
        $genreService->deleteGenre($genreId);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$genres = $genreRepository->getAllGenres();

if ($error) {
    echo $twig->render('genres_admin.twig', ['error' => $error, 'genres' => $genres]);
} else {
    header("Location: genres_admin.php");
    exit();
}
