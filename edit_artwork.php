<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

use App\Controller\ArtworkController;
use App\Factory\ArtworkServiceFactory;
use App\Repository\ArtistRepository;
use App\Repository\ArtworkRepository;
use App\Repository\GenreRepository;
use App\Repository\ImageRepository;
use App\Service\ArtistService;
use App\Service\GenreService;
use App\Service\ImageService;

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once (__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

$artworkService = ArtworkServiceFactory::create($pdo);
$artistRepository = new ArtistRepository($pdo);
$genreRepository = new GenreRepository($pdo);
$imageRepository = new ImageRepository($pdo);
$artworkRepository = new ArtworkRepository($pdo);
$artistService = new ArtistService($artistRepository, $artworkService);
$genreService = new GenreService($genreRepository);
$imageService = new ImageService($imageRepository);
$artworkController = new ArtworkController($artworkService, $artistService, $genreService, $imageService, $twig);

$error = null;
$artwork = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $artworkId = $_POST['id'] ?? null;
    $title = $_POST['title'] ?? '';
    $artistId = $_POST['artistId'] ?? '';
    $genreId = $_POST['genreId'] ?? '';
    $creationYear = $_POST['creationYear'] ?? '';
    $dimensions = $_POST['dimensions'] ?? '';
    $imageId = $_POST['imageId'] ?? '';
    $altText = $_POST['altText'] ?? '';

    $image = $_FILES['image']['name'] ?? null;

    $genreId = (int) $genreId;
    $imageId = (int) $imageId;

    $newImagePath = null;

    try {
        $artworkService->checkDuplicateArtworkEdit($title, $artistId, $artworkId);
        if (!empty($image)) {
            $newImagePath = $imageRepository->saveImageFile($_FILES['image']['tmp_name']);
            if ($newImagePath) {
                $imageId = $imageService->saveImage($newImagePath, $altText);
            }
        } else {
            $imageId = $artworkRepository->getArtworkById($artworkId)->getImageId();
            $imageService->updateAltText($imageId, $altText);
        }

        $artworkController->editArtwork(
            (int)$artworkId,
            $title,
            (int)$artistId,
            $genreId,
            $creationYear,
            $dimensions,
            $imageId,
            $oldImageId ?? null,
            !empty($newImagePath),
        );
    } catch (Exception $e) {
        $error = $e->getMessage();
        $artworkId = $_POST['id'] ?? null;
        if ($artworkId !== null) {
            $artwork = $artworkService->getArtworkById($artworkId);
        }
    }
} else {
    $artworkId = $_GET['id'] ?? null;
    if ($artworkId === null) {
        $artwork = $artworkService->getArtworkById($artworkId);
    }
}

if ($artwork === null && $artworkId !== null) {
    $artwork = $artworkService->getArtworkById($artworkId);
}

$artists = $artistService->getAllArtists();
$genres = $genreService->getAllGenres();

echo $twig->render('edit_artwork.twig', ['artwork' => $artwork, 'artists' => $artists, 'genres' => $genres, 'error' => $error]);

