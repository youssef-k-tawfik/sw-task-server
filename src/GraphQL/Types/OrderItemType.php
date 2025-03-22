<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Config\Container;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class OrderItemType extends ObjectType
{
    public function __construct(Container $container)
    {
        parent::__construct([
            'name' => 'OrderItem',
            'fields' => [
                'product' => Type::nonNull(
                    $container->get(ProductType::class)
                ),
                'quantity' => Type::nonNull(Type::int()),
                'selectedAttributes' => Type::nonNull(Type::listOf(
                    $container->get(SelectedAttributeType::class)
                )),
            ],
        ]);
    }
}
