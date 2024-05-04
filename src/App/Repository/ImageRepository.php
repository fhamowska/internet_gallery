<?php

namespace App\Repository;

use App\Service\ImageService;
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
        return $result ?? '';
    }

    public function saveImage(string $imagePath, string $altText): int
    {
        var_dump($altText);
        $query = "INSERT INTO Images (image_path, alt_text) VALUES (:imagePath, :altText)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':imagePath', $imagePath, PDO::PARAM_STR);
        $stmt->bindParam(':altText', $altText, PDO::PARAM_STR);
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    public function saveImageFile(string $imagePath): string
    {
        $newImagePath = './images/artworks/' . uniqid() . '.jpg';
        move_uploaded_file($_FILES['image']['tmp_name'], $newImagePath);
        return $newImagePath;
    }

    public function updateAltText(int $imageId, string $altText): void
    {
        $query = "UPDATE Images SET alt_text = :altText WHERE id = :imageId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':imageId', $imageId, PDO::PARAM_INT);
        $stmt->bindParam(':altText', $altText, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function deleteImage($imageId)
    {
        $query = "SELECT id FROM Artworks WHERE image_id = :imageId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':imageId', $imageId, PDO::PARAM_INT);
        $stmt->execute();
        $artworkIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($artworkIds as $artworkId) {
            $this->deleteArtwork($artworkId);
        }

        $query = "SELECT image_path FROM Images WHERE id = :imageId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':imageId', $imageId, PDO::PARAM_INT);
        $stmt->execute();
        $imagePath = $stmt->fetchColumn();

        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }

        $query = "DELETE FROM Images WHERE id = :imageId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':imageId', $imageId, PDO::PARAM_INT);
        $stmt->execute();
    }

    private function deleteArtwork($artworkId)
    {
        $query = "SELECT image_id FROM Artworks WHERE id = :artworkId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':artworkId', $artworkId, PDO::PARAM_INT);
        $stmt->execute();
        $imageId = $stmt->fetchColumn();

        $query = "DELETE FROM Artworks WHERE id = :artworkId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':artworkId', $artworkId, PDO::PARAM_INT);
        $stmt->execute();

        if ($imageId) {
            $this->deleteImage($imageId);
        }
    }

    public function getAltTextById(int $imageId): ?string
    {
        $query = "SELECT alt_text FROM Images WHERE id = :image_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':image_id' => $imageId]);
        return $stmt->fetchColumn();
    }
}
