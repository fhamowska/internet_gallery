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

    public function getFilteredArtworks(int $page, int $perPage, array $filters): array
    {
        $query = "SELECT * FROM Artworks 
          LEFT JOIN Artists ON Artworks.artist_id = Artists.id
          LEFT JOIN Genres ON Artworks.genre_id = Genres.id
          LEFT JOIN Images ON Artworks.image_id = Images.id
          LEFT JOIN Admins ON Artworks.created_by = Admins.id
          WHERE 1=1";

        $params = [];

        if (!empty($filters['genre'])) {
            $query .= " AND Artworks.genre_id = :genre";
            $params[':genre'] = $filters['genre'];
        }

        if (!empty($filters['creationYearFrom'])) {
            $query .= " AND Artworks.creation_year >= :creationYearFrom";
            $params[':creationYearFrom'] = $filters['creationYearFrom'];
        }

        if (!empty($filters['creationYearTo'])) {
            $query .= " AND Artworks.creation_year <= :creationYearTo";
            $params[':creationYearTo'] = $filters['creationYearTo'];
        }

        if (!empty($filters['searchTerm'])) {
            $query .= " AND (Artworks.title LIKE :searchTerm OR Artists.first_name LIKE :searchTerm OR Artists.last_name LIKE :searchTerm)";
            $params[':searchTerm'] = '%' . $filters['searchTerm'] . '%';
        }

        // Add pagination
        $offset = ($page - 1) * $perPage;
        $query .= " LIMIT :limit OFFSET :offset";

        // Prepare the query
        $stmt = $this->pdo->prepare($query);

        // Bind other parameters
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        // Bind pagination parameters
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch and return artworks
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

    public function getTotalFilteredArtworksCount(array $filters): int
    {
        $query = "SELECT COUNT(*) FROM Artworks 
          LEFT JOIN Artists ON Artworks.artist_id = Artists.id
          LEFT JOIN Genres ON Artworks.genre_id = Genres.id
          LEFT JOIN Images ON Artworks.image_id = Images.id
          LEFT JOIN Admins ON Artworks.created_by = Admins.id
          WHERE 1=1";

        $params = [];

        if (!empty($filters['genre'])) {
            $query .= " AND Artworks.genre_id = :genre";
            $params[':genre'] = $filters['genre'];
        }

        if (!empty($filters['creationYearFrom'])) {
            $query .= " AND Artworks.creation_year >= :creationYearFrom";
            $params[':creationYearFrom'] = $filters['creationYearFrom'];
        }

        if (!empty($filters['creationYearTo'])) {
            $query .= " AND Artworks.creation_year <= :creationYearTo";
            $params[':creationYearTo'] = $filters['creationYearTo'];
        }

        if (!empty($filters['searchTerm'])) {
            $query .= " AND (Artworks.title LIKE :searchTerm OR Artists.first_name LIKE :searchTerm OR Artists.last_name LIKE :searchTerm)";
            $params[':searchTerm'] = '%' . $filters['searchTerm'] . '%';
        }

        $stmt = $this->pdo->prepare($query);

        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function searchArtworks(string $searchTerm, int $page, int $perPage): array
    {
        // Construct the query to search artworks by title and artist names
        $query = "SELECT * FROM Artworks 
          LEFT JOIN Artists ON Artworks.artist_id = Artists.id
          LEFT JOIN Genres ON Artworks.genre_id = Genres.id
          LEFT JOIN Images ON Artworks.image_id = Images.id
          LEFT JOIN Admins ON Artworks.created_by = Admins.id
          WHERE Artworks.title LIKE :searchTerm 
          OR Artists.first_name LIKE :searchTerm 
          OR Artists.last_name LIKE :searchTerm";

        // Add pagination
        $offset = ($page - 1) * $perPage;
        $query .= " LIMIT :limit OFFSET :offset";

        // Prepare the query
        $stmt = $this->pdo->prepare($query);

        // Bind parameters
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch and return artworks
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
}
