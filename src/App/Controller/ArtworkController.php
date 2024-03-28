<?php

namespace App\Controller;

use App\Service\ArtworkService;
use Twig\Environment;

class ArtworkController
{
    private ArtworkService $artworkService;
    private Environment $twig;

    public function __construct(ArtworkService $artworkService, Environment $twig)
    {
        $this->artworkService = $artworkService;
        $this->twig = $twig;
    }

    public function index()
    {
        $artworks = $this->artworkService->getAllArtworksWithDetails();

        echo $this->twig->render('artworks.twig', ['artworks' => $artworks]);
    }
}
