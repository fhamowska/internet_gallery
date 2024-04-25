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

$artistId = $_POST['id'] ?? null;

if ($_SERVER["REQUEST_METHOD"] === "POST" && $artistId !== null) {
    $artistController->deleteArtist((int)$artistId);
}

header("Location: artists.php");
exit();
