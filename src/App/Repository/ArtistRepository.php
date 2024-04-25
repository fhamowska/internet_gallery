<?php

namespace App\Repository;
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PDO;

class ArtistRepository {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllArtists()
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

    public function editArtist(int $artistId, string $firstName, string $lastName, ?string $dateOfBirth, ?string $dateOfDeath): void
    {
        $query = "UPDATE Artists 
              SET first_name = :firstName, 
                  last_name = :lastName, 
                  date_of_birth = :dateOfBirth, 
                  date_of_death = :dateOfDeath 
              WHERE id = :artistId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':artistId', $artistId, PDO::PARAM_INT);
        $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':dateOfBirth', $dateOfBirth, PDO::PARAM_STR);
        $stmt->bindParam(':dateOfDeath', $dateOfDeath, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function addArtist(string $firstName, string $lastName, ?string $dateOfBirth, ?string $dateOfDeath): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO Artists (first_name, last_name, date_of_birth, date_of_death) VALUES (:firstName, :lastName, :dateOfBirth, :dateOfDeath)");
        $stmt->execute([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'dateOfBirth' => $dateOfBirth,
            'dateOfDeath' => $dateOfDeath,
        ]);
    }

    public function getArtistByNameAndDates(string $firstName, string $lastName, ?string $dateOfBirth, ?string $dateOfDeath)
    {
        $query = "SELECT * FROM Artists WHERE first_name = :firstName AND last_name = :lastName AND date_of_birth = :dateOfBirth AND date_of_death = :dateOfDeath";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'firstName' => $firstName,
            'lastName' => $lastName,
            'dateOfBirth' => $dateOfBirth,
            'dateOfDeath' => $dateOfDeath,
        ]);
        return $stmt->fetch();
    }

    public function deleteArtist(int $artistId): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM Artists WHERE id = :id");
        $stmt->bindParam(':id', $artistId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
