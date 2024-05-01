<?php

namespace App\Service;

use App\Repository\ArtistRepository;

class ArtistService {

    private ArtistRepository $artistRepository;
    private ArtworkService $artworkService;

    public function __construct(ArtistRepository $artistRepository, ArtworkService $artworkService)
    {
        $this->artistRepository = $artistRepository;
        $this->artworkService = $artworkService;
    }

    public function getAllArtists(): array
    {
        return $this->artistRepository->getAllArtists();
    }

    public function editArtist(int $artistId, string $firstName, string $lastName, ?string $yearOfBirth, ?string $yearOfDeath): void
    {
        $this->artistRepository->editArtist($artistId, $firstName, $lastName, $yearOfBirth, $yearOfDeath);
    }

    public function getArtistById(int $artistId): ?array
    {
        return $this->artistRepository->getArtistById($artistId);
    }

    public function addArtist(string $firstName, string $lastName, ?string $yearOfBirth, ?string $yearOfDeath): ?string
    {
        $existingArtist = $this->artistRepository->getArtistByNameAndDates($firstName, $lastName, $yearOfBirth, $yearOfDeath);

        if ($existingArtist) {
            return 'An artist with the same name and dates already exists.';
        }

        $this->artistRepository->addArtist($firstName, $lastName, $yearOfBirth, $yearOfDeath);
        return null;
    }

    public function deleteArtist(int $artistId)
    {
        $artworksUsingArtist = $this->artworkService->getArtworkCountByArtistId($artistId);

        if ($artworksUsingArtist > 0) {
            return 'Cannot delete the artist. The artist is associated with one or more artworks.';
        }

        $this->artistRepository->deleteArtist($artistId);
        return null;
    }
}

