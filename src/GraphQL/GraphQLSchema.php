<?php

declare(strict_types=1);

namespace App\GraphQL;

use App\GraphQL\Resolvers\OrderResolver;
use App\GraphQL\Resolvers\ProductResolver;
use App\GraphQL\Resolvers\CategoryResolver;

use App\GraphQL\Types\ProductType;
use App\GraphQL\Types\CategoryType;
use App\GraphQL\Types\OrderResponseType;
use App\GraphQL\Types\OrderItemInputType;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;

use App\Config\Container;
use App\GraphQL\Types\OrderItemType;

class GraphQLSchema
{
    public static function build(Container $container): Schema
    {
        $queryType = new ObjectType([
            'name' => 'Query',
            'fields' => [
                'categories' => [
                    'type' => Type::listOf(
                        $container->get(CategoryType::class)
                    ),
                    'resolve' => [
                        $container->get(CategoryResolver::class),
                        'getCategories'
                    ],
                ],
                'products' => [
                    'type' => Type::listOf(
                        $container->get(ProductType::class)
                    ),
                    'args' => [
                        'category' => Type::string(),
                        'id' => Type::string(),
                    ],
                    'resolve' => [
                        $container->get(ProductResolver::class),
                        'getProducts'
                    ],
                ],
                'dates' => [
                    'type' => Type::listOf(Type::string()),
                    'args' => [
                        'orders' => Type::listOf(Type::string()),
                    ],
                    'resolve' => [
                        $container->get(OrderResolver::class),
                        'getDates'
                    ],
                ],
                // 'order' => [
                //     'type' => Type::listOf(
                //         $container->get(OrderItemType::class)
                //     ),
                //     'args' => [
                //         'orderNumber' => Type::string(),
                //     ],
                //     'resolve' => [
                //         $container->get(OrderResolver::class),
                //         'getOrder'
                //     ],
                // ],
            ]
        ]);

        $mutationType = new ObjectType([
            'name' => 'Mutation',
            'fields' => [
                'placeOrder' => [
                    'type' => $container->get(OrderResponseType::class),
                    'args' => [
                        'orderItems' => [
                            'type' =>
                            Type::nonNull(
                                Type::listOf(
                                    $container->get(OrderItemInputType::class)
                                )
                            ),
                        ],
                    ],
                    'resolve' => [
                        $container->get(OrderResolver::class),
                        'placeOrder'
                    ],
                ],
            ],
        ]);

        return new Schema(
            (new SchemaConfig())
                ->setQuery($queryType)
                ->setMutation($mutationType)
        );
    }
}
