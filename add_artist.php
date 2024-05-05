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
$inputValues = [
    'first_name' => '',
    'last_name' => '',
    'year_of_birth' => '',
    'year_of_death' => ''
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $yearOfBirth = $_POST['year_of_birth'] ?? null;
    $yearOfDeath = $_POST['year_of_death'] ?? null;

    $inputValues = [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'year_of_birth' => $yearOfBirth,
        'year_of_death' => $yearOfDeath
    ];

    try {
        $artistController->addArtist($firstName, $lastName, $yearOfBirth, $yearOfDeath);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

echo $twig->render('add_artist.twig', ['error' => $error, 'inputValues' => $inputValues]);
