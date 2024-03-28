<?php

namespace App\Service;

use App\Repository\ImageRepository;

class ImageService
{
    private $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function getAllImages()
    {
        return $this->imageRepository->getAllImages();
    }
}