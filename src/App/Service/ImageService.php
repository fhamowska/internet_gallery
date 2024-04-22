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

    public function saveImage(string $imagePath, string $altText): int
    {
        return $this->imageRepository->saveImage($imagePath, $altText);
    }

    public function deleteImage(int $imageId): void
    {
        $this->imageRepository->deleteImage($imageId);
    }
}