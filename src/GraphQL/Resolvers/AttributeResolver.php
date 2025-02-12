<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Repository\AttributeRepository;

class AttributeResolver
{
    private AttributeRepository $attributeRepository;

    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function getAttributes($root)
    {
        try {
        } catch (\Exception $e) {
            throw new \Exception("Error fetching attributes: {$e->getMessage()}");
        }
    }
}
