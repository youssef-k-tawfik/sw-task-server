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

    public function getAttributes($root): array
    {
        try {
            $productId = $root['id'];

            $attributes = $this->attributesRepository
                ->fetchAttributes($productId);

            $attributes = $this->mapAttributes($attributes);
            CustomLogger::debug($attributes);
            return $attributes;
        } catch (\Exception $e) {
            throw new \Exception("Error fetching attributes: {$e->getMessage()}");
        }
    }

    /**
     * Map attributes to the requested format by the task
     * 
     * @param array $attributes
     * 
     * @return array
     */
    private function mapAttributes(array $attributes): array
    {
        /*
        ^retrieved attribute sample format
        (
            [id] => White
            [value] => #FFFFFF
            [displayValue] => White
            [attributeSetId] => Color
            [attributeSetName] => Color
            [attributeSetType] => swatch
        )

        ^requested return format example
        {
            "id": "Capacity",
            "items": [
                {
                    "displayValue": "256GB",
                    "value": "256GB",
                    "id": "256GB",
                    "__typename": "Attribute"
                }
            ],
            "name": "Capacity",
            "type": "text",
            "__typename": "AttributeSet"
        }
        */

        $mappedAttributes = [];
        foreach ($attributes as $attribute) {
            $attributeSetId = $attribute['attributeSetId'];
            $attributeSetName = $attribute['attributeSetName'];
            $attributeSetType = $attribute['attributeSetType'];

            $attributeItem = [
                'displayValue' => $attribute['displayValue'],
                'value' => $attribute['value'],
                'id' => $attribute['id'],
            ];

            $attributeSet = [
                'id' => $attributeSetId,
                'items' => [$attributeItem],
                'name' => $attributeSetName,
                'type' => $attributeSetType,
            ];

            // If the attribute set already exists, 
            // add the attribute item to the items array
            // else create a new attribute set
            if (array_key_exists($attributeSetId, $mappedAttributes)) {
                $mappedAttributes[$attributeSetId]['items'][] = $attributeItem;
            } else {
                $mappedAttributes[$attributeSetId] = $attributeSet;
            }
        }

        return $mappedAttributes;
    }
}
