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

    public function getAllArtworks(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;

        $query = "SELECT * FROM Artworks 
              LEFT JOIN Artists ON Artworks.artist_id = Artists.id
              LEFT JOIN Genres ON Artworks.genre_id = Genres.id
              LEFT JOIN Images ON Artworks.image_id = Images.id
              LEFT JOIN Admins ON Artworks.created_by = Admins.id
              LIMIT :perPage OFFSET :offset";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

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

    public function getTotalArtworksCount(): int
    {
        $query = "SELECT COUNT(*) FROM Artworks";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchColumn();
    }
}
