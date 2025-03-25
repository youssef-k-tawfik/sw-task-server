<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Order;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\Config\Container;

use App\GraphQL\Types\ProductType;
use App\GraphQL\Types\Attribute\SelectedAttributeType;

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
