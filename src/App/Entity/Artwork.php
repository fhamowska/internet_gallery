<?php

namespace App\Entity;

class Artwork
{
    private int $id;
    private string $title;
    private int $artistId;
    private int $genreId;
    private ?int $creationYear;
    private ?string $dimensions;
    private int $imageId;
    private string $createdAt;
    private ?string $editedAt;
    private int $createdBy;

    public function __construct(
        int $id,
        string $title,
        int $artistId,
        int $genreId,
        int $creationYear = null,
        string $dimensions = null,
        int $imageId = null,
        int $createdBy = null
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->artistId = $artistId;
        $this->genreId = $genreId;
        $this->creationYear = $creationYear;
        $this->dimensions = $dimensions;
        $this->imageId = $imageId;
        $this->createdBy = $createdBy;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getArtistId(): int
    {
        return $this->artistId;
    }

    public function setArtistId(int $artistId): void
    {
        $this->artistId = $artistId;
    }

    public function getGenreId(): int
    {
        return $this->genreId;
    }

    public function setGenreId(int $genreId): void
    {
        $this->genreId = $genreId;
    }

    public function getCreationYear(): ?int
    {
        return $this->creationYear;
    }

    public function setCreationYear(int $creationYear): void
    {
        $this->creationYear = $creationYear;
    }

    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }

    public function setDimensions(string $dimensions): void
    {
        $this->dimensions = $dimensions;
    }

    public function getImageId(): int
    {
        return $this->imageId;
    }

    public function setImageId(int $imageId): void
    {
        $this->imageId = $imageId;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getEditedAt(): ?string
    {
        return $this->editedAt;
    }

    public function setEditedAt(string $editedAt): void
    {
        $this->editedAt = $editedAt;
    }

    public function getCreatedBy(): int
    {
        return $this->createdBy;
    }

    public function setCreatedBy(int $createdBy): void
    {
        $this->createdBy = $createdBy;
    }
}
