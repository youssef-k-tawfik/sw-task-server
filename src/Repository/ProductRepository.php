<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function fetchAllProducts(): array
    {
        return [];
    }

    public function fetchByCategory(string $category): array
    {
        return [];
    }
}
