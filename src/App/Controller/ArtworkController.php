<?php

namespace App\Controller;

use App\Service\ArtistService;
use App\Service\ArtworkService;
use App\Service\GenreService;
use App\Service\ImageService;
use Twig\Environment;

class ArtworkController
{
    private ArtworkService $artworkService;
    private Environment $twig;
    private ArtistService $artistService;
    private GenreService $genreService;
    private ImageService $imageService;

    public function __construct(ArtworkService $artworkService, ArtistService $artistService, GenreService $genreService, ImageService $imageService, Environment $twig)
    {
        $this->artworkService = $artworkService;
        $this->artistService = $artistService;
        $this->genreService = $genreService;
        $this->imageService = $imageService;
        $this->twig = $twig;
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
            'creationYearFrom' => $_GET['creationYearFrom'] ?? null,
            'creationYearTo' => $_GET['creationYearTo'] ?? null,
            'searchTerm' => $_GET['searchTerm'] ?? null,
        ];

        $queryString = http_build_query($filters);
        $queryString = $queryString ? '&' . $queryString : '';

        $page = max(1, (int)$_GET['page']);

        if (str_contains($_SERVER['REQUEST_URI'], '/~21_hamowska/licencjat/admin.php')) {
            $perPage = 3;
            $artworks = $this->artworkService->getFilteredArtworksWithDetails($page, $perPage, $filters);
            $totalArtworks = $this->artworkService->getTotalFilteredArtworksCount($filters);
            $totalPages = ceil($totalArtworks / $perPage);
            if (!isset($_GET['page'])) {
                header("Location: admin.php?page=1$queryString");
                exit();
            }
            echo $this->twig->render('admin.twig', [
                'artworks' => $artworks,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'filters' => $filters,
                'genres' => $genres,
                'searchTerm' => $filters['searchTerm'],
            ]);
        } else {
            $perPage = 8;
            $artworks = $this->artworkService->getFilteredArtworksWithDetails($page, $perPage, $filters);
            $totalArtworks = $this->artworkService->getTotalFilteredArtworksCount($filters);
            $totalPages = ceil($totalArtworks / $perPage);
            if (!isset($_GET['page'])) {
                header("Location: gallery.php?page=1$queryString");
                exit();
            }
            echo $this->twig->render('artworks.twig', [
                'artworks' => $artworks,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'filters' => $filters,
                'genres' => $genres,
                'searchTerm' => $filters['searchTerm'],
            ]);
        }
    }

    public function editArtwork($artworkId, $title, $artistId, $genreId, $creationYear, $dimensions, $medium, $imageId, ?int $oldImageId, $updateImage = true)
    {
        if (!$updateImage) {
            $imageId = null;
        }

        $this->artworkService->editArtwork($artworkId, $title, $artistId, $genreId, $creationYear, $dimensions, $medium, $imageId);
        if($oldImageId !== null && $updateImage)
        {
            $this->imageService->deleteImage($oldImageId);
        }
        header("Location: admin.php");
        exit();
    }

}
