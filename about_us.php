<?php

use App\Factory\ArtworkServiceFactory;
use App\Repository\ArtistRepository;
use App\Repository\GenreRepository;
use App\Service\ArtistService;
use App\Service\GenreService;

require_once(__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

$artworkService = ArtworkServiceFactory::create($pdo);
$artistRepository = new ArtistRepository($pdo);
$artistService = new ArtistService($artistRepository, $artworkService);
$genreRepository = new GenreRepository($pdo);
$genreService = new GenreService($genreRepository);

$totalArtworks = $artworkService->getTotalArtworks();
$totalArtists = $artistService->getTotalArtists();
$totalGenres = $genreService->getTotalGenres();

echo $twig->render('about_us.twig', [
    'totalArtworks' => $totalArtworks,
    'totalArtists' => $totalArtists,
    'totalGenres' => $totalGenres,
]);
