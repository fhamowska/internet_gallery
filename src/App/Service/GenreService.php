<?php

namespace App\Service;

use App\Repository\GenreRepository;
use Exception;

class GenreService
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository) {
        $this->genreRepository = $genreRepository;
    }

    public function getAllGenres(): array
    {
        return $this->genreRepository->getAllGenres();
    }

    public function getGenreById(int $genreId)
    {
        return $this->genreRepository->getGenreById($genreId);
    }

    public function updateGenre(int $genreId, string $name)
    {
        $this->genreRepository->updateGenre($genreId, $name);
    }

    public function deleteGenre(int $genreId): void
    {
        $artworksUsingGenre = $this->genreRepository->getArtworkCountByGenreId($genreId);

        if ($artworksUsingGenre > 0) {
            throw new Exception('Nie można usunąć kategorii, do której należą dzieła.');
        }

        $this->genreRepository->deleteGenre($genreId);
    }

    public function addGenre(string $name)
    {
        $this->genreRepository->addGenre($name);
    }

    public function getGenreByName(string $name)
    {
        return $this->genreRepository->getGenreByName($name);
    }

    public function getTotalGenres()
    {
        return $this->genreRepository->getTotalGenres();
    }
}