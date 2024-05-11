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
    private string $medium;
    private string $imagePath;
    private string $altText;
    private string $description;
    private string $username;
    private string $createdAt;
    private ?string $editedAt;
    private int $createdBy;
    private string $artistYearOfBirth;
    private ?string $artistYearOfDeath;
    private int $artistId;
    private int $genreId;

    public function __construct(
        int     $id,
        string  $title,
        int $artistId,
        int $genreId,
        string  $artistName,
        string  $artistYearOfBirth,
        ?string $artistYearOfDeath,
        string  $genreName,
        ?int    $creationYear,
        ?string $dimensions,
        string $medium,
        string  $imagePath,
        string  $altText,
        string $description,
        string  $username,
        string  $createdAt,
        ?string $editedAt,
        int     $createdBy
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->artistId = $artistId;
        $this->genreId = $genreId;
        $this->artistName = $artistName;
        $this->artistYearOfBirth = $artistYearOfBirth;
        $this->artistYearOfDeath = $artistYearOfDeath;
        $this->genreName = $genreName;
        $this->creationYear = $creationYear;
        $this->dimensions = $dimensions;
        $this->medium = $medium;
        $this->imagePath = $imagePath;
        $this->altText = $altText;
        $this->description = $description;
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

    public function getArtistId(): int
    {
        return $this->artistId;
    }

    public function getGenreId(): int
    {
        return $this->genreId;
    }

    public function getArtistName(): string
    {
        return $this->artistName;
    }

    public function getGenreName(): string
    {
        return $this->genreName;
    }

    public function getArtistYearOfBirth(): string
    {
        return $this->artistYearOfBirth;
    }

    public function getArtistYearOfDeath(): string
    {
        return $this->artistYearOfDeath;
    }

    public function getCreationYear(): ?int
    {
        return $this->creationYear;
    }

    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }

    public function getMedium(): string
    {
        return $this->medium;
    }

    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    public function getAltText(): string
    {
        return $this->altText;
    }

    public function getDescription(): string
    {
        return $this->description;
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
