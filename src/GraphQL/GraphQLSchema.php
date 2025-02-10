<?php

declare(strict_types=1);

namespace App\GraphQL;

use App\GraphQL\Resolvers\OrderResolver;
use App\GraphQL\Resolvers\ProductResolver;
use App\GraphQL\Resolvers\CategoryResolver;

use App\GraphQL\Types\OrderResponseType;
use App\GraphQL\Types\ProductType;
use App\GraphQL\Types\CategoryType;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;

use App\Config\Container;
use App\Repository\CategoryRepository;
use App\Service\CategoryService;

class GraphQLSchema
{
    public static function build(): Schema
    {
        $container = new Container();

        $queryType = new ObjectType([
            'name' => 'Query',
            'fields' => [
                'categories' => [
                    'type' => Type::listOf(new CategoryType()),
                    'resolve' => [$container->get(CategoryResolver::class), 'getCategories'],
                ],
                // 'products' => [
                //     'type' => Type::listOf(new ProductType()),
                //     'resolve' => [$container->get(ProductResolver::class), 'getProducts'],
                // ],
            ]
        ]);

        $mutationType = new ObjectType([
            'name' => 'Mutation',
            'fields' => [
                'InsertOrder' => [
                    'type' => new OrderResponseType(),
                    'args' => [
                        'number' => Type::nonNull(Type::int()),
                    ],
                    'resolve' => [OrderResolver::class, 'insertOrder'],
                ],
            ]
        ]);

        return new Schema(
            (new SchemaConfig())
                ->setQuery($queryType)
                ->setMutation($mutationType)
        );
    }
}
