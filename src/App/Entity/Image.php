<?php

namespace App\Entity;

class Image {
    private int $id;
    private string $imagePath;
    private string $altText;

    public function __construct($imagePath, $altText) {
        $this->imagePath = $imagePath;
        $this->altText = $altText;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setImagePath($imagePath): void
    {
        $this->imagePath = $imagePath;
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    public function setAltText($altText): void
    {
        $this->altText = $altText;
    }

    public function getAltText(): string
    {
        return $this->altText;
    }
}