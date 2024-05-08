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
        $artists = $this->artistService->getAllArtists();
        echo $this->twig->render('artists_admin.twig', ['artists' => $artists]);
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

