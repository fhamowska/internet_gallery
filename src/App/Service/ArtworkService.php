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

    public function getAllArtworksWithDetails(): array
    {
        $artworks = $this->artworkRepository->getAllArtworks();
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
