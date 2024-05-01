<?php
use App\Controller\ArtistController;
use App\Factory\ArtworkServiceFactory;
use App\Repository\ArtistRepository;
use App\Service\ArtistService;

require_once(__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';


$artistRepository = new ArtistRepository($pdo);
$artworkService = ArtworkServiceFactory::create($pdo);
$artistService = new ArtistService($artistRepository, $artworkService);
$artistController = new ArtistController($artistService, $twig);

$error = null;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
$firstName = $_POST['first_name'] ?? '';
$lastName = $_POST['last_name'] ?? '';
$yearOfBirth = $_POST['year_of_birth'] ?? null;
$yearOfDeath = $_POST['year_of_death'] ?? null;

$error = $artistController->addArtist($firstName, $lastName, $yearOfBirth, $yearOfDeath);
}

echo $twig->render('add_artist.twig', ['error' => $error]);
