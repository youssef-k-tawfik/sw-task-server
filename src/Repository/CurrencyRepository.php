<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

use App\Entity\Price\Currency;

class CurrencyRepository extends EntityRepository
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $currencyRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->currencyRepository = $this
            ->entityManager
            ->getRepository(Currency::class);
    }

    public function fetchCurrency(int $currencyId): array
    {
        return $this->currencyRepository
            ->createQueryBuilder('c')
            ->select('c.label', 'c.symbol')
            ->where('c.id = :currencyId')
            ->setParameter('currencyId', $currencyId)
            ->getQuery()
            ->getSingleResult();
    }
}
