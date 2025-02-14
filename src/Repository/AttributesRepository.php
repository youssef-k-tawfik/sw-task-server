<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Attribute;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class AttributesRepository extends EntityRepository
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $attributesRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->attributesRepository = $this
            ->entityManager
            ->getRepository(Attribute::class);
    }

    public function fetchAttributes(): array
    {
        return $this->attributesRepository
            ->createQueryBuilder('a')
            ->getQuery()
            ->getSingleResult();
    }
}
