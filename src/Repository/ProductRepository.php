<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $productRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->productRepository = $this
            ->entityManager
            ->getRepository(Product::class);
    }

    public function getAllProducts(?string $category = null): array
    {
        $queryBuilder = $this->productRepository
            ->createQueryBuilder('p')
            ->select(
                'p.id',
                'p.name',
                'p.description',
                'p.brand',
                'p.inStock',
                'c.name AS category',
                'g.url AS gallery',
            )
            ->leftJoin('p.category', 'c')
            ->leftJoin('p.gallery', 'g');

        if ($category) {
            $queryBuilder->where('c.name = :category')
                ->setParameter('category', $category);
        }

        return $queryBuilder->getQuery()->getScalarResult();
    }
}
