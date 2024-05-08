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

    public function saveImage(string $imagePath, string $altText): int
    {
        return $this->imageRepository->saveImage($imagePath, $altText);
    }

    public function deleteImage(int $imageId): void
    {
        $this->imageRepository->deleteImage($imageId);
    }

    public function updateAltText(int $imageId, string $altText): void
    {
        $this->imageRepository->updateAltText($imageId, $altText);
    }
}