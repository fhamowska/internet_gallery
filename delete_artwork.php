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


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $artworkId = $_POST['id'];

    $artwork = $artworkRepository->getArtworkById($artworkId);
    $imageId = $artwork->getImageId();
    if ($imageId) {
        $imageService->deleteImage($imageId);
    }
    $artworkRepository->deleteArtwork($artworkId);
}

header("Location: admin.php");
exit();
