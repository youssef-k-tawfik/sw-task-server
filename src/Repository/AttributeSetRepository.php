<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AttributeSet;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class AttributeSetRepository extends EntityRepository
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $attributeSetRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->attributeSetRepository = $this
            ->entityManager
            ->getRepository(AttributeSet::class);
    }

    public function fetchAttributeSets(): array
    {
        return $this->attributeSetRepository
            ->createQueryBuilder('as')
            ->getQuery()
            ->getSingleResult();
    }
}
