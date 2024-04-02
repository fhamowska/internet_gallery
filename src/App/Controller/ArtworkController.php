<?php

namespace App\Controller;

use App\Repository\ArtworkRepository;
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
        if (!isset($_GET['page'])) {
            header("Location: gallery.php?page=1");
            exit();
        }

        $page = max(1, (int)$_GET['page']);
        $perPage = 1;

        $artworks = $this->artworkService->getAllArtworksWithDetails($page, $perPage);
        $totalArtworks = $this->artworkService->getTotalArtworksCount();
        $totalPages = ceil($totalArtworks / $perPage);

        echo $this->twig->render('artworks.twig', [
            'artworks' => $artworks,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }

}
