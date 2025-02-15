<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Price;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PriceRepository extends EntityRepository
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $priceRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->priceRepository = $this
            ->entityManager
            ->getRepository(Price::class);
    }

    public function fetchAllPrices(string $productId): array
    {
        return $this->priceRepository
            ->createQueryBuilder('p')
            ->select('p.amount', 'IDENTITY(p.currency) as currencyId')
            ->where('p.product = :productId')
            ->setParameter('productId', $productId)
            ->getQuery()
            ->getArrayResult();
    }
}
