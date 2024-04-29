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
    private string $username;
    private string $createdAt;
    private ?string $editedAt;
    private int $createdBy;

    public function __construct(
        int $id,
        string $title,
        string $artistName,
        string $genreName,
        ?int $creationYear,
        ?string $dimensions,
        string $imagePath,
        string $altText,
        string $username,
        string $createdAt,
        ?string $editedAt,
        int $createdBy
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->artistName = $artistName;
        $this->genreName = $genreName;
        $this->creationYear = $creationYear;
        $this->dimensions = $dimensions;
        $this->imagePath = $imagePath;
        $this->altText = $altText;
        $this->username = $username;
        $this->createdAt = $createdAt;
        $this->editedAt = $editedAt;
        $this->createdBy = $createdBy;
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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getEditedAt(): ?string
    {
        return $this->editedAt;
    }

    public function getCreatedBy(): int
    {
        return $this->createdBy;
    }
}
