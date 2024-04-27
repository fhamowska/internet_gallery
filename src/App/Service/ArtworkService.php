<?php

namespace App\Service;

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

    public function __construct(
        ArtworkRepository $artworkRepository,
        ArtistRepository $artistRepository,
        GenreRepository $genreRepository,
        ImageRepository $imageRepository
    ) {
        $this->artworkRepository = $artworkRepository;
        $this->artistRepository = $artistRepository;
        $this->genreRepository = $genreRepository;
        $this->imageRepository = $imageRepository;
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

            $artworkDetails[] = new ArtworkDetailsDTO(
                $artwork->getId(),
                $artwork->getTitle(),
                $artistName,
                $genreName,
                $artwork->getCreationYear(),
                $artwork->getDimensions(),
                $imagePath,
                $altText,
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

        return new ArtworkDetailsDTO(
            $artwork->getId(),
            $artwork->getTitle(),
            $artistName,
            $genreName,
            $artwork->getCreationYear(),
            $artwork->getDimensions(),
            $imagePath
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
