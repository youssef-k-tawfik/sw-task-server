<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

class ProductResolver
{
    public static function getProducts(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Product 1',
                'price' => 100,
            ],
            [
                'id' => 2,
                'name' => 'Product 2',
                'price' => 200,
            ],
            [
                'id' => 3,
                'name' => 'Product 3',
                'price' => 300,
            ],
        ];
    }
}
