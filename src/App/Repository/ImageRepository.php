<?php

namespace App\Repository;

use PDO;

class ImageRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllImages()
    {
        $query = "SELECT * FROM Images";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImagePathById(int $imageId): string
    {
        $query = "SELECT image_path FROM Images WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $imageId);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        return $result ?? ''; // Return the image path or an empty string if not found
    }
}
