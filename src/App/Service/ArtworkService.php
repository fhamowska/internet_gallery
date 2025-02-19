<?php

namespace App\Service;

use App\Repository\AdminRepository;
use App\Repository\ArtworkRepository;
use App\Repository\ArtistRepository;
use App\Repository\GenreRepository;
use App\Repository\ImageRepository;
use App\DTO\ArtworkDetailsDTO;
use Exception;

class ArtworkService
{
    private ArtworkRepository $artworkRepository;
    private ArtistRepository $artistRepository;
    private GenreRepository $genreRepository;
    private ImageRepository $imageRepository;
    private AdminRepository $adminRepository;

    public function __construct(
        ArtworkRepository $artworkRepository,
        ArtistRepository $artistRepository,
        GenreRepository $genreRepository,
        ImageRepository $imageRepository,
        AdminRepository $adminRepository,
    ) {
        $this->artworkRepository = $artworkRepository;
        $this->artistRepository = $artistRepository;
        $this->genreRepository = $genreRepository;
        $this->imageRepository = $imageRepository;
        $this->adminRepository = $adminRepository;
    }

    public function getFilteredArtworksWithDetails(int $page, int $perPage, array $filters): array
    {
        $artworks = $this->artworkRepository->getFilteredArtworks($page, $perPage, $filters);
        $artworkDetails = [];

        foreach ($artworks as $artwork) {
            $artistName = $this->artistRepository->getArtistNameById($artwork->getArtistId());
            $genreName = $this->genreRepository->getGenreNameById($artwork->getGenreId());
            $imagePath = $this->imageRepository->getImagePathById($artwork->getImageId());
            $altText = $this->imageRepository->getAltTextById($artwork->getImageId());
            $description = $this->imageRepository->getDescriptionById($artwork->getImageId());
            $username = $this->adminRepository->getUsernameById($artwork->getCreatedBy());
            $artistYearOfBirth = $this->artistRepository->GetYearOfBirthById($artwork->getArtistId());
            $artistYearOfDeath = $this->artistRepository->GetYearOfDeathById($artwork->getArtistId());


            $artworkDetails[] = new ArtworkDetailsDTO(
                $artwork->getId(),
                $artwork->getTitle(),
                $artwork->getArtistId(),
                $artwork->getGenreId(),
                $artistName,
                $artistYearOfBirth,
                $artistYearOfDeath,
                $genreName,
                $artwork->getCreationYear(),
                $artwork->getDimensions(),
                $artwork->getMedium(),
                $imagePath,
                $altText,
                $description,
                $username,
                $artwork->getCreatedAt(),
                $artwork->getEditedAt(),
                $artwork->getCreatedBy(),
            );
        }

        return $artworkDetails;
    }

    public function getTotalFilteredArtworksCount(array $filters): int
    {
        return $this->artworkRepository->getTotalFilteredArtworksCount($filters);
    }

    public function getArtworkById(int $artworkId): ?ArtworkDetailsDTO
    {
        $artwork = $this->artworkRepository->getArtworkById($artworkId);

        if ($artwork === null) {
            return null;
        }

        $artistName = $this->artistRepository->getArtistNameById($artwork->getArtistId());
        $genreName = $this->genreRepository->getGenreNameById($artwork->getGenreId());
        $imagePath = $this->imageRepository->getImagePathById($artwork->getImageId());
        $altText = $this->imageRepository->getAltTextById($artwork->getImageId());
        $description = $this->imageRepository->getDescriptionById($artwork->getImageId());
        $username = $this->adminRepository->getUsernameById($artwork->getCreatedBy());
        $artistYearOfBirth = $this->artistRepository->GetYearOfBirthById($artwork->getArtistId());
        $artistYearOfDeath = $this->artistRepository->GetYearOfDeathById($artwork->getArtistId());

        return new ArtworkDetailsDTO(
            $artwork->getId(),
            $artwork->getTitle(),
            $artwork->getArtistId(),
            $artwork->getGenreId(),
            $artistName,
            $artistYearOfBirth,
            $artistYearOfDeath,
            $genreName,
            $artwork->getCreationYear(),
            $artwork->getDimensions(),
            $artwork->getMedium(),
            $imagePath,
            $altText,
            $description,
            $username,
            $artwork->getCreatedAt(),
            $artwork->getEditedAt(),
            $artwork->getCreatedBy(),
        );
    }

    public function editArtwork(int $artworkId, string $title, int $artistId, int $genreId, int $creationYear, string $dimensions, string $medium, ?string $imageId): void
    {
        $this->artworkRepository->editArtwork($artworkId, $title, $artistId, $genreId, $creationYear, $dimensions, $medium, $imageId);
    }

    public function getArtworkCountByArtistId(int $artistId): int
    {
        return $this->artworkRepository->getArtworkCountByArtistId($artistId);
    }

    public function getRandomArtworkId()
    {
        return $this->artworkRepository->getRandomArtworkId();
    }

    public function addArtwork(string $title, int $artistId, int $genreId, ?int $creationYear, ?string $dimensions, int $imageId, int $createdBy, string $medium)
    {
        $this->artworkRepository->addArtwork($title, $artistId, $genreId, $creationYear, $dimensions, $imageId, $createdBy, $medium);
    }

    public function checkDuplicateArtwork(string $title, int $artistId): void
    {
        if ($this->artworkRepository->isDuplicate($title, $artistId)) {
            throw new Exception("Dzieło artysty o tym tytule już istnieje.");
        }
    }

    public function checkDuplicateArtworkEdit(string $title, int $artistId, int $artworkId): void
    {
        if ($this->artworkRepository->isDuplicateWhenEdit($title, $artistId, $artworkId)) {
            throw new Exception("Dzieło artysty o tym tytule już istnieje.");
        }
    }

    public function getTotalArtworks()
    {
        return $this->artworkRepository->getTotalArtworks();
    }
}
