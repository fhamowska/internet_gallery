<?php

namespace App\Repository;

use PDO;

class GenreRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllGenres(): array
    {
        $query = "SELECT * FROM Genres";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGenreById(int $genreId)
    {
        $query = "SELECT * FROM Genres WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $genreId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }


    public function getGenreNameById(int $genreId): string
    {
        $query = "SELECT name FROM Genres WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $genreId);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result ?? '';
    }

    public function updateGenre(int $genreId, string $name)
    {
        $query = "UPDATE Genres SET name = :name WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':id', $genreId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteGenre(int $genreId): void
    {
        $sql = "DELETE FROM Genres WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $genreId]);
    }

    public function getArtworkCountByGenreId(int $genreId): int
    {
        $sql = "SELECT COUNT(*) FROM Artworks WHERE genre_id = :genreId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['genreId' => $genreId]);
        return (int)$stmt->fetchColumn();
    }

    public function addGenre(string $name)
    {
        $stmt = $this->pdo->prepare("INSERT INTO Genres (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);
    }

    public function getGenreByName(string $name)
    {
        $query = "SELECT * FROM Genres WHERE name = :name";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['name' => $name]);
        return $stmt->fetch();
    }
}

