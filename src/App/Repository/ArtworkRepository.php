<?php

namespace App\Repository;

use App\Entity\Artwork;
use PDO;

class ArtworkRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllArtworks(): array
    {
        $query = "SELECT * FROM Artworks 
                  LEFT JOIN Artists ON Artworks.artist_id = Artists.id
                  LEFT JOIN Genres ON Artworks.genre_id = Genres.id
                  LEFT JOIN Images ON Artworks.image_id = Images.id
                  LEFT JOIN Admins ON Artworks.created_by = Admins.id";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $artworks = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $artwork = new Artwork(
                $row['id'],
                $row['title'],
                $row['artist_id'],
                $row['genre_id'],
                $row['creation_year'],
                $row['dimensions'],
                $row['image_id'],
                $row['created_by']
            );

            $artworks[] = $artwork;
        }

        return $artworks;
    }

    public function getArtistNameById(int $artistId): ?string
    {
        $query = "SELECT name FROM Artists WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $artistId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getGenreNameById(int $genreId): ?string
    {
        $query = "SELECT name FROM Genres WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $genreId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getImagePathById(int $imageId): ?string
    {
        $query = "SELECT path FROM Images WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $imageId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

}