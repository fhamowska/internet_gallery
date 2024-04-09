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

}