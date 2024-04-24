<?php

namespace App\Controller;

use App\Repository\GenreRepository;
use App\Service\GenreService;
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

    public function listGenres()
    {
        $genres = $this->genreService->getAllGenres();
        echo $this->twig->render('genres.twig', ['genres' => $genres]);
    }

    public function editGenre(int $genreId, string $name)
    {
        $this->genreService->updateGenre($genreId, $name);
        header("Location: genres.php");
        exit();
    }

    public function addGenre(string $name): ?string
    {
        $existingGenre = $this->genreService->getGenreByName($name);
        if ($existingGenre) {
            return 'Genre with the same name already exists.';
        }
        $this->genreService->addGenre($name);
        return null;
    }
}
