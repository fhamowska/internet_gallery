<?php

namespace App\Service;

use App\Repository\GenreRepository;

class GenreService
{
    private $genreRepository;

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
            echo 'Cannot delete the genre. It is used in one or more artworks.';
            exit();
        }

        $this->genreRepository->deleteGenre($genreId);
    }

    public function addGenre(string $name): ?string
    {
        $existingGenre = $this->genreRepository->getGenreByName($name);
        if ($existingGenre) {
            return 'Genre with the same name already exists.';
        }
        $this->genreRepository->addGenre($name);
        return null;
    }
}