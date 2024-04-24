<?php

namespace App\Controller;

use App\Service\ArtworkService;
use App\Service\GenreService;
use Twig\Environment;

class AdminController
{
    private Environment $twig;
    private ArtworkService $artworkService;
    private GenreService $genreService;

    public function __construct(Environment $twig, ArtworkService $artworkService, GenreService $genreService)
    {
        $this->twig = $twig;
        $this->artworkService = $artworkService;
        $this->genreService = $genreService;
    }

    public function index()
    {
        $genres = $this->genreService->getAllGenres();

        $genreArray = $_GET['genre'] ?? [];

        if (!is_array($genreArray)) {
            $genreArray = explode(',', $genreArray);
            $genreArray = array_map('trim', $genreArray);
            $genreArray = array_map('strval', $genreArray);
        }

        $filters = [
            'genre' => $genreArray,
            'creationYearFrom' => isset($_GET['creationYearFrom']) ? (int)$_GET['creationYearFrom'] : null,
            'creationYearTo' => isset($_GET['creationYearTo']) ? (int)$_GET['creationYearTo'] : null,
            'searchTerm' => $_GET['searchTerm'] ?? null,
        ];

        $queryString = http_build_query($filters);
        $queryString = $queryString ? '&' . $queryString : '';

        if (!isset($_GET['page'])) {
            header("Location: admin.php?page=1$queryString");
            exit();
        }

        $page = max(1, (int)$_GET['page']);
        $perPage = 2;

        $artworks = $this->artworkService->getFilteredArtworksWithDetails($page, $perPage, $filters);
        $totalArtworks = $this->artworkService->getTotalFilteredArtworksCount($filters);
        $totalPages = ceil($totalArtworks / $perPage);

        if (isset($filters['genre']) && is_array($filters['genre'])) {
            $filters['genre'] = implode(',', $filters['genre']);
        }

        echo $this->twig->render('admin.twig', [
            'artworks' => $artworks,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'filters' => $filters,
            'genres' => $genres,
            'searchTerm' => $filters['searchTerm'],
        ]);
    }
}
