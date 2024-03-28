<?php

namespace App\Controller;

use App\Service\ArtistService;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ArtistController {
    private $artistService;
    private $twig;

    public function __construct(ArtistService $artistService) {
        $this->artistService = $artistService;

        // Initialize Twig environment
        $loader = new FilesystemLoader(__DIR__ . '/../View');
        $this->twig = new Environment($loader);
    }

    public function showAllArtists() {
        $artists = $this->artistService->getAllArtists();
        // Render the view using Twig
        echo $this->twig->render('artists_view.twig', ['artists' => $artists]);
    }
}

