<?php

namespace App\Controller;

use App\Repository\GenreRepository;
use App\Service\GenreService;
use Exception;
use Twig\Environment;

class GenreController
{
    private GenreService $genreService;
    private Environment $twig;
    public function __construct(GenreService $genreService, Environment $twig)
    {
        $this->genreService = $genreService;
        $this->twig = $twig;
    }

    public function listGenres(): void
    {
        $genres = $this->genreService->getAllGenres();
        echo $this->twig->render('genres_admin.twig', ['genres' => $genres]);
    }

    public function editGenre(int $genreId, string $name): void
    {
        $existingGenre = $this->genreService->getGenreByName($name);
        if ($existingGenre && $existingGenre['id'] !== $genreId) {
            throw new Exception("Kategoria '$name' już istnieje.");
        }
        $this->genreService->updateGenre($genreId, $name);
        header("Location: genres_admin.php");
        exit();
    }

    public function addGenre(string $name): void
    {
        $existingGenre = $this->genreService->getGenreByName($name);
        if ($existingGenre) {
            throw new Exception("Kategoria '$name' już istnieje.");
        }
        $this->genreService->addGenre($name);
        header("Location: genres_admin.php");
        exit();
    }
}
