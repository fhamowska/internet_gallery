<?php

namespace App\Service;

use App\Repository\ArtistRepository;
use Exception;

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

    public function getAllFilteredArtists(int $page, int $perPage, string $searchTerm): array
    {
        return $this->artistRepository->getAllFilteredArtists($page, $perPage, $searchTerm);
    }

    public function getTotalFilteredArtistsCount(string $searchTerm): int
    {
        return $this->artistRepository->getTotalFilteredArtistsCount($searchTerm);
    }

    public function editArtist(int $artistId, string $firstName, string $lastName, ?string $yearOfBirth, ?string $yearOfDeath): void
    {
        var_dump($firstName, $lastName);
        if ($yearOfBirth !== null && ($yearOfDeath !== null && $yearOfDeath !== '' && $yearOfDeath < $yearOfBirth)) {
            throw new Exception("Rok śmierci nie może być wcześniej niż rok urodzenia.");
        }
        $duplicateArtist = $this->artistRepository->getArtistByName($firstName, $lastName);
        if ($duplicateArtist && $duplicateArtist['id'] !== $artistId) {
            $artistName = $duplicateArtist['first_name'] . ' ' . $duplicateArtist['last_name'];
            throw new Exception("Artysta '$artistName' już istnieje.");
        }
        $this->artistRepository->editArtist($artistId, $firstName, $lastName, $yearOfBirth, (int)$yearOfDeath);
    }

    public function getArtistById(int $artistId): ?array
    {
        return $this->artistRepository->getArtistById($artistId);
    }

    public function addArtist(string $firstName, string $lastName, ?int $yearOfBirth, ?int $yearOfDeath): void
    {
        if ($yearOfBirth !== null && $yearOfDeath !== null && $yearOfDeath < $yearOfBirth) {
            throw new Exception("Rok śmierci nie może być przed rokiem urodzenia.");
        }

        if ($this->artistRepository->isDuplicate($firstName, $lastName, $yearOfBirth, $yearOfDeath)) {
            throw new Exception("Ten artysta już istnieje.");
        }

        $this->artistRepository->addArtist($firstName, $lastName, $yearOfBirth, $yearOfDeath);
    }

    public function deleteArtist(int $artistId)
    {
        $artworksUsingArtist = $this->artworkService->getArtworkCountByArtistId($artistId);

        if ($artworksUsingArtist > 0) {
            throw new Exception('Nie można usunąć artysty, do którego przypisane są dzieła.');
        }

        $this->artistRepository->deleteArtist($artistId);
    }
    public function getTotalArtists()
    {
        return $this->artistRepository->getTotalArtists();
    }

    public function getTotalArtworksByArtistId($id): int
    {
        return $this->artworkService->getArtworkCountByArtistId($id);
    }
}

