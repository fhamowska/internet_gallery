<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Twig\Environment;

class ImageController
{
    private $imageRepository;
    private $twig;

    public function __construct(ImageRepository $imageRepository, Environment $twig)
    {
        $this->imageRepository = $imageRepository;
        $this->twig = $twig;
    }

    public function showAllImages()
    {
        $images = $this->imageRepository->getAllImages();

        echo $this->twig->render('images_view.twig', ['images' => $images]);
    }
}
