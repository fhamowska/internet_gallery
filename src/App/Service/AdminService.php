<?php

namespace App\Service;

use App\Entity\Admin;
use App\Repository\AdminRepository;

class AdminService
{
    private AdminRepository $adminRepository;

    public function __construct(AdminRepository $adminRepository) {
        $this->adminRepository = $adminRepository;
    }

    public function findByUsername(string $username): ?Admin
    {
        return $this->adminRepository->findByUsername($username);
    }

}
