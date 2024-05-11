<?php

namespace App\Service;

use App\Repository\ImageRepository;

class ImageService
{
    private ImageRepository $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function saveImage(string $imagePath, string $altText, string $description): int
    {
        return $this->imageRepository->saveImage($imagePath, $altText, $description);
    }

    public function deleteImage(int $imageId): void
    {
        $this->imageRepository->deleteImage($imageId);
    }

    public function updateImage(int $imageId, string $altText, string $description): void
    {
        $this->imageRepository->updateAltText($imageId, $altText, $description);
    }
}