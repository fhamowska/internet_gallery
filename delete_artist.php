<?php

use App\Controller\ArtistController;
use App\Factory\ArtworkServiceFactory;
use App\Repository\ArtistRepository;
use App\Service\ArtistService;

require_once(__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

$artworkService = ArtworkServiceFactory::create($pdo);
$artistRepository = new ArtistRepository($pdo);
$artistService = new ArtistService($artistRepository, $artworkService);
$artistController = new ArtistController($artistService, $twig);

$artistId = $_GET['id'] ?? null;

if ($_SERVER["REQUEST_METHOD"] === "GET" && $artistId !== null) {
    try {
        $artistController->deleteArtist((int)$artistId);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$artists = $artistService->getAllArtists();

if ($error) {
    echo $twig->render('artists.twig', ['error' => $error, 'artists' => $artists]);
} else {
    header("Location: artists.php");
    exit();
}
