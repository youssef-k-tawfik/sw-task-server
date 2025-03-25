<?php

declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Category;
use App\Utils\CustomLogger;

class CategoryService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllCategories(): array
    {
        $categoryRepository = $this
            ->entityManager
            ->getRepository(Category::class);

        //~ DQL approach: Using QueryBuilder to fetch only the category names
        $categories = $categoryRepository
            ->createQueryBuilder('c')
            ->select('c.name')
            ->getQuery()
            ->getScalarResult();

        //~ OOP approach: Fetching all categories and then mapping to get names
        // $categories = $categoryRepository->findAll();
        // $categories = array_map(
        //     fn($category) => ["name" => $category->getName()],
        //     $categories
        // );

        CustomLogger::debug(__FILE__, __LINE__, $categories);
        CustomLogger::logInfo('Fetched all categories');
        return $categories;
    }
}
