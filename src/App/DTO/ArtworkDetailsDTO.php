<?php

namespace App\DTO;

class ArtworkDetailsDTO
{
    private int $id;
    private string $title;
    private string $artistName;
    private string $genreName;
    private ?int $creationYear;
    private ?string $dimensions;
    private string $imagePath;
    private string $altText;

    public function __construct(int $id, string $title, string $artistName, string $genreName, ?int $creationYear, ?string $dimensions, string $imagePath, string $altText)
    {
        $this->id = $id;
        $this->title = $title;
        $this->artistName = $artistName;
        $this->genreName = $genreName;
        $this->creationYear = $creationYear;
        $this->dimensions = $dimensions;
        $this->imagePath = $imagePath;
        $this->altText = $altText;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getArtistName(): string
    {
        return $this->artistName;
    }

    public function getGenreName(): string
    {
        return $this->genreName;
    }

    public function getCreationYear(): ?int
    {
        return $this->creationYear;
    }

    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    public function getAltText(): string
    {
        return $this->altText;
    }
}
