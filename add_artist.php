<?php
use App\Controller\ArtistController;
use App\Repository\ArtistRepository;
use App\Repository\ArtworkRepository;
use App\Repository\GenreRepository;
use App\Repository\ImageRepository;
use App\Service\ArtistService;
use App\Service\ArtworkService;

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
$artistController = new ArtistController($artistService, $twig);

$error = null;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
$firstName = $_POST['first_name'] ?? '';
$lastName = $_POST['last_name'] ?? '';
$dateOfBirth = $_POST['date_of_birth'] ?? null;
$dateOfDeath = $_POST['date_of_death'] ?? null;

$error = $artistController->addArtist($firstName, $lastName, $dateOfBirth, $dateOfDeath);
}

echo $twig->render('add_artist.twig', ['error' => $error]);
