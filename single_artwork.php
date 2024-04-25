<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once (__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

use App\Controller\ArtworkController;
use App\Repository\ArtistRepository;
use App\Repository\ArtworkRepository;
use App\Repository\GenreRepository;
use App\Repository\ImageRepository;
use App\Service\ArtistService;
use App\Service\ArtworkService;
use App\Service\GenreService;
use App\Service\ImageService;

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

$artworkId = $_GET['id'] ?? null;

$artwork = $artworkService->getArtworkById($artworkId);

echo $twig->render('single_artwork.twig', ['artwork' => $artwork]);
