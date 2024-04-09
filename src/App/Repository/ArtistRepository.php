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

    public function getAllArtists(): array
    {
        $query = "SELECT * FROM Artists";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
}
