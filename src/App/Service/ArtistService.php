<?php

namespace App\Service;

use App\Repository\ArtistRepository;

class ArtistService {
    private $artistRepository;

    public function __construct(ArtistRepository $artistRepository) {
        $this->artistRepository = $artistRepository;
    }

    public function getAllArtists(): array
    {
        return $this->artistRepository->getAllArtists();
    }

    public function editArtist(int $artistId, string $firstName, string $lastName, ?string $dateOfBirth, ?string $dateOfDeath): void
    {
        $this->artistRepository->editArtist($artistId, $firstName, $lastName, $dateOfBirth, $dateOfDeath);
    }

    public function getArtistById(int $artistId): ?array
    {
        return $this->artistRepository->getArtistById($artistId);
    }
}

