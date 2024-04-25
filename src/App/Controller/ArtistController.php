<?php

namespace App\Controller;

use App\Service\ArtistService;
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

    public function listArtists()
    {
        $artists = $this->artistService->getAllArtists();
        echo $this->twig->render('artists.twig', ['artists' => $artists]);
    }

    public function editArtist(int $artistId, string $firstName, string $lastName, ?string $dateOfBirth, ?string $dateOfDeath): void
    {
        $this->artistService->editArtist($artistId, $firstName, $lastName, $dateOfBirth, $dateOfDeath);
        header("Location: artists.php");
        exit();
    }

    public function addArtist(string $firstName, string $lastName, ?string $dateOfBirth, ?string $dateOfDeath)
    {
        $error = $this->artistService->addArtist($firstName, $lastName, $dateOfBirth, $dateOfDeath);

        if ($error === null) {
            header("Location: artists.php");
            exit();
        }

        return $error;
    }

    public function deleteArtist(int $artistId)
    {
        $error = $this->artistService->deleteArtist($artistId);
        if ($error !== null) {
            echo $error;
            exit();
        }
        header("Location: artists.php");
        exit();
    }
}

