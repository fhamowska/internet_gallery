<?php

use App\Controller\ArtistController;
use App\Repository\ArtistRepository;
use App\Service\ArtistService;

require_once(__DIR__) . '/vendor/autoload.php';
require_once 'bootstrap.php';

$artistRepository = new ArtistRepository($pdo);
$artistService = new ArtistService($artistRepository);
$artistController = new ArtistController($artistService, $twig);
$artistController->listArtists();
