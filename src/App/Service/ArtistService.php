<?php

namespace App\Service;

use App\Repository\ArtistRepository;

class ArtistService {
    private $artistRepository;

    public function __construct(ArtistRepository $artistRepository) {
        $this->artistRepository = $artistRepository;
    }

    public function getAllArtists() {
        return $this->artistRepository->getAllArtists();
    }
}

