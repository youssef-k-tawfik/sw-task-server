<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

use App\Entity\Attribute\Attribute;

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

    /**
     * Fetch attributes for a given product id
     * 
     * @param string $productId
     * 
     * @return array
     */
    public function fetchAttributes(string $productId): array
    {
        return $this->attributesRepository
            ->createQueryBuilder('a')
            ->innerJoin('a.products', 'p')
            ->innerJoin('a.attributeSet', 'aSet')
            ->where('p.id = :productId')
            ->setParameter('productId', $productId)
            ->select(
                'a.id',
                'a.value',
                'a.displayValue',
                'aSet.id AS attributeSetId',
                'aSet.name AS attributeSetName',
                'aSet.type AS attributeSetType'
            )
            ->getQuery()
            ->getArrayResult();
    }
}
