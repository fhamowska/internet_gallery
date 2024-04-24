<?php
use App\Repository\GenreRepository;
use App\Service\GenreService;

require_once(__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

$genreRepository = new GenreRepository($pdo);
$genreService = new GenreService($genreRepository);

$error = null;
$genreId = $_POST['id'] ?? '';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $genreId = $_POST['id'];
    $genreService->deleteGenre($genreId);
}

header("Location: genres.php");
exit();
