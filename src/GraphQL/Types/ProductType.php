<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Config\Container;
use App\GraphQL\Resolvers\AttributesResolver;
use App\GraphQL\Resolvers\PriceResolver;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductType extends ObjectType
{
    public function __construct(Container $container)
    {
        parent::__construct([
            'name' => 'Product',
            'fields'
            => [
                'id' => Type::nonNull(Type::string()),
                'name' => Type::nonNull(Type::string()),
                'description' => Type::string(),
                'inStock' => Type::boolean(),
                'brand' => Type::nonNull(Type::string()),
                'category' => Type::nonNull(Type::string()),
                'gallery' => Type::listOf(Type::nonNull(Type::string())),
                'prices' => [
                    'type' => Type::listOf(Type::nonNull(
                        $container->get(PriceType::class)
                    )),
                    'resolve' => [
                        $container->get(PriceResolver::class),
                        'getAllPrices'
                    ]
                ],
                'attributes' => [
                    'type' => Type::listOf(Type::nonNull(
                        $container->get(AttributeSetType::class)
                    )),
                    'resolve' => [
                        $container->get(AttributesResolver::class),
                        'getAttributes'
                    ]
                ],
            ],
        ]);
    }
}
