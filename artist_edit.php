<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

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

$error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $artistId = $_POST['id'] ?? null;
    $firstName = $_POST['first_name'] ?? '';
    $lastName = $_POST['last_name'] ?? '';
    $yearOfBirth = $_POST['year_of_birth'] ?? '';
    $yearOfDeath = $_POST['year_of_death'] ?? '';

    try {
        $artistController->editArtist((int)$artistId, $firstName, $lastName, $yearOfBirth, $yearOfDeath);
    } catch (Exception $e) {
        $error = $e->getMessage();
        $artist = $artistService->getArtistById($artistId);
        echo $twig->render('edit_artist.twig', ['artist' => $artist, 'error' => $error]);
        exit();
    }
}

$artistId = $_GET['id'] ?? '';
$artist = $artistService->getArtistById((int)$artistId);

echo $twig->render('edit_artist.twig', ['artist' => $artist, 'error' => $error]);