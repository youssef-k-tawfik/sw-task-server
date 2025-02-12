<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Attribute;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class AttributeRepository extends EntityRepository
{
    private EntityManagerInterface $entityManager;
    private EntityRepository $attributeRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->attributeRepository = $this
            ->entityManager
            ->getRepository(Attribute::class);
    }

    public function fetchAttributes(): array
    {
        return $this->attributeRepository
            ->createQueryBuilder('a')
            ->getQuery()
            ->getSingleResult();
    }
}
