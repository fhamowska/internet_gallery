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
        $query = "INSERT INTO Images (image_path, alt_text) VALUES (:imagePath, :altText)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':imagePath', $imagePath, PDO::PARAM_STR);
        $stmt->bindParam(':altText', $altText, PDO::PARAM_STR);
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    public function saveImageFile(string $imagePath): string
    {
        $newImagePath = './images/' . uniqid() . '.jpg';
        move_uploaded_file($_FILES['image']['tmp_name'], $newImagePath);
        return $newImagePath;
    }

    public function deleteImage($imageId)
    {
        // Get the image path before deleting it
        $query = "SELECT image_path FROM Images WHERE id = :imageId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':imageId', $imageId, PDO::PARAM_INT);
        $stmt->execute();
        $imagePath = $stmt->fetchColumn();

        // Delete the image file
        if ($imagePath && file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Update Artworks to remove the reference to the image
        $query = "UPDATE Artworks SET image_id = NULL WHERE image_id = :imageId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':imageId', $imageId, PDO::PARAM_INT);
        $stmt->execute();

        // Delete the image record from the database
        $query = "DELETE FROM Images WHERE id = :imageId";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':imageId', $imageId, PDO::PARAM_INT);
        $stmt->execute();
    }

}
