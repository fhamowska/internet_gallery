<?php
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

$artworkRepository = new ArtworkRepository($pdo);
$artistRepository = new ArtistRepository($pdo);
$genreRepository = new GenreRepository($pdo);
$imageRepository = new ImageRepository($pdo);
$artworkService = ArtworkServiceFactory::create($pdo);
$artistService = new ArtistService($artistRepository, $artworkService);
$genreService = new GenreService($genreRepository);
$imageService = new ImageService($imageRepository);
$artworkController = new ArtworkController($artworkService, $artistService, $genreService, $imageService, $twig);

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $artworkId = $_GET['id'];

    $artwork = $artworkRepository->getArtworkById($artworkId);
    $imageId = $artwork->getImageId();
    if ($imageId) {
        $imageService->deleteImage($imageId);
    }
    $artworkRepository->deleteArtwork($artworkId);
}

header("Location: artworks_admin.php");
exit();
