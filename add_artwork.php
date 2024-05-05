<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Controller\ArtworkController;
use App\Factory\ArtworkServiceFactory;
use App\Repository\ArtistRepository;
use App\Repository\ArtworkRepository;
use App\Repository\GenreRepository;
use App\Repository\ImageRepository;
use App\Service\ArtistService;
use App\Service\GenreService;
use App\Service\ImageService;

require_once(__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}
$loggedInAdminId = $_SESSION['admin_id'];

$artworkRepository = new ArtworkRepository($pdo);
$artistRepository = new ArtistRepository($pdo);
$genreRepository = new GenreRepository($pdo);
$imageRepository = new ImageRepository($pdo);

$artworkService = ArtworkServiceFactory::create($pdo);
$artistService = new ArtistService($artistRepository, $artworkService);
$genreService = new GenreService($genreRepository);
$imageService = new ImageService($imageRepository);

$artworkController = new ArtworkController($artworkService, $artistService, $genreService, $imageService, $twig);

$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'] ?? '';
    $artistId = $_POST['artistId'] ?? '';
    $genreId = $_POST['genreId'] ?? '';
    $creationYear = $_POST['creationYear'] ?? '';
    $dimensions = $_POST['dimensions'] ?? '';
    $altText = $_POST['altText'] ?? '';

    try {
        $artworkService->checkDuplicateArtwork($title, $artistId);
        $imagePath = $imageRepository->saveImageFile($_FILES['image']['tmp_name']);
        $imageId = $imageRepository->saveImage($imagePath, $altText);
        $artworkService->addArtwork($title, $artistId, $genreId, (int)$creationYear, $dimensions, $imageId, $loggedInAdminId);
        header("Location: admin.php");
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$artists = $artistService->getAllArtists();
$genres = $genreService->getAllGenres();

echo $twig->render('add_artwork.twig', ['artists' => $artists, 'genres' => $genres, 'error' => $error]);

?>
