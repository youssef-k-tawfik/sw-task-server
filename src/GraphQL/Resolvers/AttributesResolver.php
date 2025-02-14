<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

use App\Repository\AttributesRepository;
use App\Utils\CustomLogger;

class AttributesResolver
{
    private AttributesRepository $attributesRepository;

    public function __construct(AttributesRepository $attributesRepository)
    {
        $this->attributesRepository = $attributesRepository;
    }

    public function getAttributes($root)
    {
        try {
            $productId = $root['id'];
            CustomLogger::logInfo("hi from attributes resolver product id: {$productId}");
        } catch (\Exception $e) {
            throw new \Exception("Error fetching attributes: {$e->getMessage()}");
        }
    }
}
