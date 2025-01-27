<?php

declare(strict_types=1);

namespace App\GraphQL;

use App\GraphQL\Resolvers\OrderResolver;
use App\GraphQL\Resolvers\ProductResolver;
use App\GraphQL\Types\OrderResponseType;
use App\GraphQL\Types\ProductType;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;

class GraphQLSchema
{
    public static function build(): Schema
    {

        $queryType = new ObjectType([
            'name' => 'Query',
            'fields' => [
                'products' => [
                    'type' => Type::listOf(new ProductType()),
                    'resolve' => [ProductResolver::class, 'getProducts'],
                ],
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
