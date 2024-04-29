<?php

namespace App\Factory;

use App\Repository\AdminRepository;
use App\Repository\ArtworkRepository;
use App\Repository\ArtistRepository;
use App\Repository\GenreRepository;
use App\Repository\ImageRepository;
use App\Service\ArtworkService;

class ArtworkServiceFactory
{
    public static function create($pdo): ArtworkService
    {
        $artworkRepository = new ArtworkRepository($pdo);
        $artistRepository = new ArtistRepository($pdo);
        $genreRepository = new GenreRepository($pdo);
        $imageRepository = new ImageRepository($pdo);
        $adminRepository = new AdminRepository($pdo);

        return new ArtworkService(
            $artworkRepository,
            $artistRepository,
            $genreRepository,
            $imageRepository,
            $adminRepository,
        );
    }
}