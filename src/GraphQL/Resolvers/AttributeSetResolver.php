<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Repository\AttributeSetRepository;

class AttributeSetResolver
{
    private AttributeSetRepository $attributeSetRepository;
    private $attributeSets = [];

    public function __construct(AttributeSetRepository $attributeSetRepository)
    {
        $this->attributeSetRepository = $attributeSetRepository;
    }

    public function getAttributeSets($root)
    {
        try {
        } catch (\Exception $e) {
            throw new \Exception("Error fetching attribute sets: {$e->getMessage()}");
        }
    }
}
