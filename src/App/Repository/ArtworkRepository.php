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

    public function getFilteredArtworks(int $page, int $perPage, array $filters): array
    {
        $query = "SELECT 
              Artworks.id AS artwork_id, 
              Artworks.title, 
              Artworks.artist_id, 
              Artworks.genre_id, 
              Artworks.creation_year, 
              Artworks.dimensions, 
              Artworks.created_by,
              Artworks.created_at,
              Artworks.edited_at,
              Artworks.image_id AS artwork_image_id, 
              Artworks.created_by AS artwork_created_by, 
              Artists.id AS artist_id, 
              Artists.first_name, 
              Artists.last_name, 
              Artists.year_of_birth, 
              Artists.year_of_death,
              Genres.id AS genre_id, 
              Genres.name AS genre_name,
              Images.id AS image_id, 
              Images.image_path, 
              Images.alt_text,
              Admins.id AS admin_id, 
              Admins.username, 
              Admins.password
          FROM 
              Artworks 
              LEFT JOIN Artists ON Artworks.artist_id = Artists.id
              LEFT JOIN Genres ON Artworks.genre_id = Genres.id
              LEFT JOIN Images ON Artworks.image_id = Images.id
              LEFT JOIN Admins ON Artworks.created_by = Admins.id
          WHERE 1=1";

        $params = [];

        if (!empty($filters['genre'])) {
            $genres = is_array($filters['genre']) ? $filters['genre'] : [$filters['genre']];
            $genrePlaceholders = implode(',', array_map(function($genre) {
                return ':genre_' . $genre;
            }, array_keys($genres)));
            $query .= " AND Artworks.genre_id IN ($genrePlaceholders)";
            foreach ($genres as $index => $genre) {
                $params[':genre_' . $index] = $genre;
            }
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
            $searchTerms = explode(' ', $filters['searchTerm']);
            $searchCondition = '(';
            foreach ($searchTerms as $index => $term) {
                $searchCondition .= ($index > 0 ? ' AND ' : '') . "(Artworks.title LIKE :searchTerm$index OR Artists.first_name LIKE :searchTerm$index OR Artists.last_name LIKE :searchTerm$index)";
                $params[":searchTerm$index"] = '%' . $term . '%';
            }
            $searchCondition .= ')';
            $query .= " AND $searchCondition";
        }


        $offset = ($page - 1) * $perPage;
        $query .= " ORDER BY Artworks.created_at DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($query);

        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        $artworks = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $artwork = new Artwork(
                $row['artwork_id'],
                $row['title'],
                $row['artist_id'],
                $row['genre_id'],
                $row['created_by'],
                $row['created_at'],
                $row['image_id'],
                $row['creation_year'],
                $row['dimensions'],
                $row['edited_at'],
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
            $genres = is_array($filters['genre']) ? $filters['genre'] : [$filters['genre']];
            $genrePlaceholders = implode(',', array_map(function($genre) {
                return ':genre_' . $genre;
            }, array_keys($genres)));
            $query .= " AND Artworks.genre_id IN ($genrePlaceholders)";
            foreach ($genres as $index => $genre) {
                $params[':genre_' . $index] = $genre;
            }
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
            $searchTerms = explode(' ', $filters['searchTerm']);
            $searchCondition = '(';
            foreach ($searchTerms as $index => $term) {
                $searchCondition .= ($index > 0 ? ' AND ' : '') . "(Artworks.title LIKE :searchTerm$index OR Artists.first_name LIKE :searchTerm$index OR Artists.last_name LIKE :searchTerm$index)";
                $params[":searchTerm$index"] = '%' . $term . '%';
            }
            $searchCondition .= ')';
            $query .= " AND $searchCondition";
        }

        $stmt = $this->pdo->prepare($query);

        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function getArtworkById(int $artworkId): ?Artwork
    {
        $query = "SELECT 
              Artworks.id AS artwork_id, 
              Artworks.title, 
              Artworks.artist_id, 
              Artworks.genre_id, 
              Artworks.creation_year, 
              Artworks.dimensions, 
              Artworks.created_by,
              Artworks.created_at,
              Artworks.edited_at,
              Artworks.image_id AS artwork_image_id, 
              Artists.id AS artist_id, 
              Artists.first_name, 
              Artists.last_name, 
              Artists.year_of_birth, 
              Artists.year_of_death,
              Genres.id AS genre_id, 
              Genres.name AS genre_name,
              Images.id AS image_id, 
              Images.image_path, 
              Images.alt_text,
              Admins.id AS admin_id, 
              Admins.username
          FROM 
              Artworks 
              LEFT JOIN Artists ON Artworks.artist_id = Artists.id
              LEFT JOIN Genres ON Artworks.genre_id = Genres.id
              LEFT JOIN Images ON Artworks.image_id = Images.id
              LEFT JOIN Admins ON Artworks.created_by = Admins.id
          WHERE 
              Artworks.id = :artworkId";


        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':artworkId', $artworkId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Artwork(
            $row['artwork_id'],
            $row['title'],
            $row['artist_id'],
            $row['genre_id'],
            $row['created_by'],
            $row['created_at'],
            $row['image_id'],
            $row['creation_year'],
            $row['dimensions'],
            $row['edited_at'],
        );
    }

    public function editArtwork(string $artworkId, string $title, int $artistId, int $genreId, int $creationYear, string $dimensions, ?int $imageId)
    {
        $query = "UPDATE Artworks 
              SET title = :title, artist_id = :artistId, genre_id = :genreId, creation_year = :creationYear, dimensions = :dimensions";

        if ($imageId !== null) {
            $query .= ", image_id = :imageId";
        }

        $query .= " WHERE id = :artworkId";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':artworkId', $artworkId, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
        $stmt->bindParam(':genreId', $genreId, PDO::PARAM_INT);
        $stmt->bindParam(':creationYear', $creationYear, PDO::PARAM_INT);
        $stmt->bindParam(':dimensions', $dimensions);

        if ($imageId !== null) {
            $stmt->bindParam(':imageId', $imageId, PDO::PARAM_INT);
        }

        $stmt->execute();
    }

    public function deleteArtwork(int $artworkId)
    {
        $query = "DELETE FROM Artworks WHERE id = :artworkId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':artworkId', $artworkId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function addArtwork(string $title, int $artistId, int $genreId, ?int $creationYear, ?string $dimensions, int $imageId, int $createdBy)
    {
        $query = "INSERT INTO Artworks (title, artist_id, genre_id, creation_year, dimensions, image_id, created_by) 
              VALUES (:title, :artistId, :genreId, :creationYear, :dimensions, :imageId, :createdBy)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
        $stmt->bindParam(':genreId', $genreId, PDO::PARAM_INT);
        $stmt->bindParam(':creationYear', $creationYear, PDO::PARAM_INT);
        $stmt->bindParam(':dimensions', $dimensions, PDO::PARAM_STR);
        $stmt->bindParam(':imageId', $imageId, PDO::PARAM_INT);
        $stmt->bindParam(':createdBy', $createdBy, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getArtworkCountByArtistId(int $artistId): int
    {
        $query = "SELECT COUNT(*) FROM Artworks WHERE artist_id = :artist_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['artist_id' => $artistId]);
        return (int)$stmt->fetchColumn();
    }

    public function getRandomArtworkId()
    {
        $query = "SELECT id FROM Artworks ORDER BY RAND() LIMIT 1";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchColumn();
    }

    public function isDuplicate(string $title, int $artistId): bool
    {
        $query = "SELECT COUNT(*) AS count FROM Artworks WHERE title = :title AND artist_id = :artist_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['title' => $title, 'artist_id' => $artistId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public function isDuplicateWhenEdit(string $title, int $artistId, int $artworkId): bool
    {
        $query = "SELECT COUNT(*) AS count FROM Artworks WHERE title = :title AND artist_id = :artist_id AND id != :artwork_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['title' => $title, 'artist_id' => $artistId, 'artwork_id' => $artworkId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
}
