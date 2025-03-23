<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Price;

use App\Config\Container;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\GraphQL\Resolvers\CurrencyResolver;

class PriceType extends ObjectType
{
    public function __construct(Container $container)
    {
        parent::__construct([
            'name' => 'Price',
            'fields'
            => [
                'amount' => Type::nonNull(Type::float()),
                'currency' => [
                    'type' => Type::nonNull($container->get(CurrencyType::class)),
                    'resolve' => [
                        $container->get(CurrencyResolver::class),
                        'getCurrency'
                    ]
                ],
            ],
        ]);
    }
}
