<?php

namespace App\Service;

use App\Repository\AdminRepository;
use App\Repository\ArtworkRepository;
use App\Repository\ArtistRepository;
use App\Repository\GenreRepository;
use App\Repository\ImageRepository;
use App\DTO\ArtworkDetailsDTO;

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
            $username = $this->adminRepository->getUsernameById($artwork->getCreatedBy());
            $artistYearOfBirth = $this->artistRepository->GetYearOfBirthById($artwork->getArtistId());
            $artistYearOfDeath = $this->artistRepository->GetYearOfDeathById($artwork->getArtistId());


            $artworkDetails[] = new ArtworkDetailsDTO(
                $artwork->getId(),
                $artwork->getTitle(),
                $artistName,
                $artistYearOfBirth,
                $artistYearOfDeath,
                $genreName,
                $artwork->getCreationYear(),
                $artwork->getDimensions(),
                $imagePath,
                $altText,
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

    public function getArtworkById(int $artworkId): ArtworkDetailsDTO
    {
        $artwork = $this->artworkRepository->getArtworkById($artworkId);

        $artistName = $this->artistRepository->getArtistNameById($artwork->getArtistId());
        $genreName = $this->genreRepository->getGenreNameById($artwork->getGenreId());
        $imagePath = $this->imageRepository->getImagePathById($artwork->getImageId());
        $altText = $this->imageRepository->getAltTextById($artwork->getImageId());
        $username = $this->adminRepository->getUsernameById($artwork->getCreatedBy());
        $artistYearOfBirth = $this->artistRepository->GetYearOfBirthById($artwork->getArtistId());
        $artistYearOfDeath = $this->artistRepository->GetYearOfDeathById($artwork->getArtistId());

        return new ArtworkDetailsDTO(
            $artwork->getId(),
            $artwork->getTitle(),
            $artistName,
            $artistYearOfBirth,
            $artistYearOfDeath,
            $genreName,
            $artwork->getCreationYear(),
            $artwork->getDimensions(),
            $imagePath,
            $altText,
            $username,
            $artwork->getCreatedAt(),
            $artwork->getEditedAt(),
            $artwork->getCreatedBy(),
        );
    }

    public function editArtwork(int $artworkId, string $title, int $artistId, int $genreId, int $creationYear, string $dimensions, ?string $imageId): void
    {
        $this->artworkRepository->editArtwork($artworkId, $title, $artistId, $genreId, $creationYear, $dimensions, $imageId);
    }

    public function getArtworkCountByArtistId(int $artistId): int
    {
        return $this->artworkRepository->getArtworkCountByArtistId($artistId);
    }

    public function getRandomArtworkId()
    {
        return $this->artworkRepository->getRandomArtworkId();
    }
}
