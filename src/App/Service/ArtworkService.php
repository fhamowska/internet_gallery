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

    public function getAllArtworksWithDetails(int $page, int $perPage): array
    {
        // Fetch artworks for the specified page and perPage limit
        $artworks = $this->artworkRepository->getAllArtworks($page, $perPage);
        $artworkDetails = [];

        foreach ($artworks as $artwork) {
            $artistName = $this->artistRepository->getArtistNameById($artwork->getArtistId());
            $genreName = $this->genreRepository->getGenreNameById($artwork->getGenreId());
            $imagePath = $this->imageRepository->getImagePathById($artwork->getImageId());

            $artworkDetails[] = new ArtworkDetailsDTO(
                $artwork->getId(),
                $artwork->getTitle(),
                $artistName,
                $genreName,
                $artwork->getCreationYear(),
                $artwork->getDimensions(),
                $imagePath
            );
        }

        return $artworkDetails;
    }

    public function getTotalArtworksCount(): int
    {
        return $this->artworkRepository->getTotalArtworksCount();
    }

    public function getFilteredArtworksWithDetails(int $page, int $perPage, array $filters): array
    {
        $artworks = $this->artworkRepository->getFilteredArtworks($page, $perPage, $filters);
        $artworkDetails = [];

        foreach ($artworks as $artwork) {
            $artistName = $this->artistRepository->getArtistNameById($artwork->getArtistId());
            $genreName = $this->genreRepository->getGenreNameById($artwork->getGenreId());
            $imagePath = $this->imageRepository->getImagePathById($artwork->getImageId());

            $artworkDetails[] = new ArtworkDetailsDTO(
                $artwork->getId(),
                $artwork->getTitle(),
                $artistName,
                $genreName,
                $artwork->getCreationYear(),
                $artwork->getDimensions(),
                $imagePath
            );
        }

        return $artworkDetails;
    }

    public function getTotalFilteredArtworksCount(array $filters): int
    {
        return $this->artworkRepository->getTotalFilteredArtworksCount($filters);
    }

    public function searchArtworks(string $searchTerm, int $page, int $perPage): array
    {
        $artworks = $this->artworkRepository->searchArtworks($searchTerm, $page, $perPage);
        $artworkDetails = [];

        foreach ($artworks as $artwork) {
            $artistName = $this->artistRepository->getArtistNameById($artwork->getArtistId());
            $genreName = $this->genreRepository->getGenreNameById($artwork->getGenreId());
            $imagePath = $this->imageRepository->getImagePathById($artwork->getImageId());

            $artworkDetails[] = new ArtworkDetailsDTO(
                $artwork->getId(),
                $artwork->getTitle(),
                $artistName,
                $genreName,
                $artwork->getCreationYear(),
                $artwork->getDimensions(),
                $imagePath
            );
        }

        return $artworkDetails;
    }
}
