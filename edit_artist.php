<?php

use App\Controller\ArtistController;
use App\Repository\ArtistRepository;
use App\Service\ArtistService;

require_once(__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

$artistRepository = new ArtistRepository($pdo);
$artistService = new ArtistService($artistRepository);
$artistController = new ArtistController($artistService, $twig);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $artistId = $_POST['id'] ?? null;
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $dateOfBirth = $_POST['date_of_birth'] ?? '';
    $dateOfDeath = $_POST['date_of_death'] ?? '';

    $artistController->editArtist((int)$artistId, $firstName, $lastName, $dateOfBirth, $dateOfDeath);
}
$artistId = $_GET['id'] ?? '';
$artist = $artistService->getArtistById((int)$artistId);

echo $twig->render('edit_artist.twig', ['artist' => $artist]);

