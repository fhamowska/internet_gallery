<?php

use App\Controller\ArtworkController;
use App\Repository\ArtistRepository;
use App\Repository\ArtworkRepository;
use App\Repository\GenreRepository;
use App\Repository\ImageRepository;
use App\Service\ArtistService;
use App\Service\ArtworkService;
use App\Service\GenreService;
use App\Service\ImageService;

require_once(__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

$artworkRepository = new ArtworkRepository($pdo);
$artistRepository = new ArtistRepository($pdo);
$genreRepository = new GenreRepository($pdo);
$imageRepository = new ImageRepository($pdo);
$artworkService = new ArtworkService(
    $artworkRepository,
    $artistRepository,
    $genreRepository,
    $imageRepository,
);
$artistService = new ArtistService($artistRepository, $artworkService);
$genreService = new GenreService($genreRepository);
$imageService = new ImageService($imageRepository);
$artworkController = new ArtworkController($artworkService, $artistService, $genreService, $imageService, $twig);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $artworkId = $_POST['id'] ?? null;
    $title = $_POST['title'] ?? '';
    $artistId = $_POST['artistId'] ?? '';
    $genreId = $_POST['genreId'] ?? '';
    $creationYear = $_POST['creationYear'] ?? '';
    $dimensions = $_POST['dimensions'] ?? '';
    $imageId = $_POST['imageId'] ?? '';

    $image = $_FILES['image']['name'] ?? null;

    $genreId = (int) $genreId;
    $imageId = (int) $imageId;

    $newImagePath = null;

    if (!empty($image)) {
        $newImagePath = $imageRepository->saveImageFile($_FILES['image']['tmp_name']);
        if ($newImagePath) {
            $imageId = $imageService->saveImage($newImagePath, 'alt text:)');
        }
        $oldImageId = $artworkRepository->getArtworkById($artworkId)->getImageId();
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
}
$artworkId = $_GET['id'] ?? null;
$artwork = $artworkService->getArtworkById($artworkId);
$artists = $artistService->getAllArtists();
$genres = $genreService->getAllGenres();

echo $twig->render('edit_artwork.twig', ['artwork' => $artwork, 'artists' => $artists, 'genres' => $genres]);
