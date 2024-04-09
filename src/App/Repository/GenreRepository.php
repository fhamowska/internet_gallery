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

    public function getGenreNameById(int $genreId): string
    {
        $query = "SELECT name FROM Genres WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $genreId);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result ?? ''; // Return the genre name or an empty string if not found
    }

    public function getAllGenres(): array
    {
        $query = "SELECT * FROM Genres";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
