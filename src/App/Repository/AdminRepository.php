<?php

namespace App\Repository;

use App\Entity\Admin;
use PDO;

class AdminRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByUsername(string $username): ?Admin
    {
        $query = "SELECT * FROM Admins WHERE username = :username";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $adminData = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$adminData) {
            return null;
        }

        $admin = new Admin();
        $admin->setId($adminData['id']);
        $admin->setUsername($adminData['username']);
        $admin->setPassword($adminData['password']);

        return $admin;
    }
}
