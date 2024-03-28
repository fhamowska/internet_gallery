<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once (__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

use App\Controller\MainController;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

//$dotenv = Dotenv::createImmutable(__DIR__ );
//$dotenv->load();
//
//$dbHost = $_ENV['DB_HOST'];
//$dbName = $_ENV['DB_NAME'];
//$dbUsername = $_ENV['DB_USER'];
//$dbPassword = $_ENV['DB_PASSWORD'];
//
//$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//$loader = new FilesystemLoader(__DIR__ . '/src/App/View');
//$twig = new Environment($loader);

$mainController = new MainController($twig);
$mainController->index();


//if ($_SERVER['REQUEST_URI'] === '/~21_hamowska/licencjat/gallery') {
//    $artworkRepository = new ArtworkRepository($pdo);
//    $artworkService = new ArtworkService($artworkRepository);
//    $mainController = new ArtworkController($artworkService, $twig);
//    $mainController->index();
//}

//use App\Controller\ImageController;
//use App\Repository\ImageRepository;
//use App\Service\ArtistService;
//use App\Service\ImageService;
//use Dotenv\Dotenv;
//use App\Repository\ArtistRepository;
//use Twig\Environment;
//use Twig\Loader\FilesystemLoader;
//
//$dotenv = Dotenv::createImmutable(__DIR__ );
//$dotenv->load();
//
//$dbHost = $_ENV['DB_HOST'];
//$dbName = $_ENV['DB_NAME'];
//$dbUsername = $_ENV['DB_USER'];
//$dbPassword = $_ENV['DB_PASSWORD'];
//
//$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
//$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//$loader = new FilesystemLoader(__DIR__ . '/src/App/View');
//$twig = new Environment($loader);

//if ($_SERVER['REQUEST_URI'] === '/image') {
//    $imageRepository = new ImageRepository($pdo);
//    $imageController = new ImageController($imageRepository, $twig);
//    $imageController->showAllImages();
//}

//$artistRepository = new ArtistRepository($pdo);
//$artistService = new ArtistService($artistRepository);
//
//// Create a Twig loader and environment
//
//// Fetch all artists
//$artists = $artistService->getAllArtists();
//
//// Render the view with Twig
//echo $twig->render('artists_view.twig', ['artists' => $artists]);

//$imageRepository = new ImageRepository($pdo);
//$imagesService = new ImageService($imageRepository);
//
//// Fetch all artists
//$images = $imagesService->getAllImages();
//
//// Render the view with Twig
//echo $twig->render('images_view.twig', ['images' => $images]);