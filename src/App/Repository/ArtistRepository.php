<?php

namespace App\Repository;
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PDO;

class ArtistRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllArtists(): bool|array
    {
        $stmt = $this->pdo->query("SELECT * FROM Artists");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArtistById(int $artistId): ?array
    {
        $query = "SELECT * FROM Artists WHERE id = :artistId";
        $statement = $this->pdo->prepare($query);
        $statement->execute(['artistId' => $artistId]);
        return $statement->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getArtistNameById(int $artistId): string
    {
        $query = "SELECT first_name, last_name FROM Artists WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $artistId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['first_name'] . ' ' . $result['last_name'];
        } else {
            return '';
        }
    }

    public function editArtist(int $artistId, string $firstName, string $lastName, ?string $yearOfBirth, ?string $yearOfDeath): void
    {
        $query = "UPDATE Artists 
              SET first_name = :firstName, 
                  last_name = :lastName, 
                  year_of_birth = :yearOfBirth, 
                  year_of_death = :yearOfDeath 
              WHERE id = :artistId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':yearOfBirth', $yearOfBirth, PDO::PARAM_STR);
        $stmt->bindParam(':yearOfDeath', $yearOfDeath, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function addArtist(string $firstName, string $lastName, ?string $yearOfBirth, ?string $yearOfDeath): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO Artists (first_name, last_name, year_of_birth, year_of_death) VALUES (:firstName, :lastName, :yearOfBirth, :yearOfDeath)");
        $stmt->execute([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'yearOfBirth' => $yearOfBirth,
            'yearOfDeath' => $yearOfDeath,
        ]);
    }

    public function deleteArtist(int $artistId): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM Artists WHERE id = :id");
        $stmt->bindParam(':id', $artistId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function GetYearOfBirthById(int $artistId): ?string
    {
        $query = "SELECT year_of_birth FROM Artists WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $artistId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() ?: null;
    }

    public function GetYearOfDeathById(int $artistId): ?string
    {
        $query = "SELECT year_of_death FROM Artists WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $artistId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() ?: null;
    }

    public function isDuplicate(string $firstName, string $lastName, ?int $yearOfBirth, ?int $yearOfDeath): bool
    {
        $query = "SELECT COUNT(*) AS count FROM Artists WHERE first_name = :first_name AND last_name = :last_name AND year_of_birth = :year_of_birth AND year_of_death = :year_of_death";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['first_name' => $firstName, 'last_name' => $lastName, 'year_of_birth' => $yearOfBirth, 'year_of_death' => $yearOfDeath]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public function getTotalArtists()
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM Artists');
        return $stmt->fetchColumn();
    }
}
