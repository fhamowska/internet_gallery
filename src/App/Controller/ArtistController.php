<?php

namespace App\Controller;

use App\Service\ArtistService;
use Exception;
use http\Env;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ArtistController {
    private ArtistService $artistService;
    private Environment $twig;

    public function __construct(ArtistService $artistService, Environment $twig) {
        $this->artistService = $artistService;
        $this->twig = $twig;
    }

    public function listArtists(): void
    {
        $searchTerm = $_GET['searchTerm'] ?? '';
        $page = max(1, isset($_GET['page']) ? (int)$_GET['page'] : 1);

        if (str_contains($_SERVER['REQUEST_URI'], '/~21_hamowska/licencjat/artists_admin.php')) {
            $perPage = 4;
            $totalArtists = $this->artistService->getTotalFilteredArtistsCount($searchTerm);
            $totalPages = ceil($totalArtists / $perPage);
            $artists = $this->artistService->getAllFilteredArtists($page, $perPage, $searchTerm);
            if (!isset($_GET['page'])) {
                header("Location: artists_admin.php?page=1&searchTerm=$searchTerm");
                exit();
            }
            echo $this->twig->render('artists_admin.twig', [
                'artists' => $artists,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'searchTerm' => $searchTerm,
            ]);
        } else {
            $perPage = 4;
            $totalArtists = $this->artistService->getTotalFilteredArtistsCount($searchTerm);
            $totalPages = ceil($totalArtists / $perPage);
            $artists = $this->artistService->getAllFilteredArtists($page, $perPage, $searchTerm);
            foreach ($artists as $key => $artist) {
                $totalArtworks = $this->artistService->getTotalArtworksByArtistId($artist['id']);
                $artists[$key]['total_artworks'] = $totalArtworks;
            }

            if (!isset($_GET['page'])) {
                header("Location: artists.php?page=1&searchTerm=$searchTerm");
                exit();
            }

            echo $this->twig->render('artists.twig', [
                'artists' => $artists,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'searchTerm' => $searchTerm,
            ]);
        }
    }

    public function editArtist(int $artistId, string $firstName, string $lastName, ?string $yearOfBirth, ?string $yearOfDeath): void
    {
        $this->artistService->editArtist($artistId, $firstName, $lastName, $yearOfBirth, $yearOfDeath);
        header("Location: artists_admin.php");
        exit();
    }

    public function addArtist(string $firstName, string $lastName, ?string $yearOfBirth, ?string $yearOfDeath): void
    {
        $this->artistService->addArtist($firstName, $lastName, $yearOfBirth, $yearOfDeath);
    }

    public function deleteArtist(int $artistId): void
    {
        $this->artistService->deleteArtist($artistId);
    }
}

