<?php

require_once(__DIR__ . '/vendor/autoload.php');
require_once 'bootstrap.php';

use App\Controller\ArtworkController;
use App\Factory\ArtworkServiceFactory;
use App\Repository\ArtistRepository;
use App\Repository\GenreRepository;
use App\Repository\ImageRepository;
use App\Service\ArtistService;
use App\Service\GenreService;
use App\Service\ImageService;

$artworkService = ArtworkServiceFactory::create($pdo);
$artistRepository = new ArtistRepository($pdo);
$genreRepository = new GenreRepository($pdo);
$imageRepository = new ImageRepository($pdo);
$artistService = new ArtistService($artistRepository, $artworkService);
$genreService = new GenreService($genreRepository);
$imageService = new ImageService($imageRepository);
$artworkController = new ArtworkController($artworkService, $artistService, $genreService, $imageService, $twig);

$artworkId = $_GET['id'] ?? null;

if ($artworkId === 'random') {
    header("Location: single_artwork_admin.php?id=" . $artworkService->getRandomArtworkId());
    exit();
}

$artwork = $artworkService->getArtworkById($artworkId);

echo $twig->render('single_artwork_admin.twig', ['artwork' => $artwork]);
