<?php

namespace App\Entity;

class Image {
    private int $id;
    private string $imagePath;
    private string $altText;
    private string $description;

    public function __construct($imagePath, $altText, $description) {
        $this->imagePath = $imagePath;
        $this->altText = $altText;
        $this->description = $description;
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

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}