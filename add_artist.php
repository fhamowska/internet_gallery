<?php
use App\Controller\ArtistController;
use App\Repository\ArtistRepository;
use App\Service\ArtistService;

require_once(__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

$artistRepository = new ArtistRepository($pdo);
$artistService = new ArtistService($artistRepository);
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
