<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Order;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

use App\Config\Container;

use App\GraphQL\Types\Attribute\SelectedAttributeInputType;

class OrderItemInputType extends InputObjectType
{
    public function __construct(Container $container)
    {
        parent::__construct([
            'name' => 'OrderItemInput',
            'fields' => [
                'productId' => ['type' => Type::nonNull(Type::string())],
                'quantity' => ['type' => Type::nonNull(Type::int())],
                'selectedAttributes' => ['type' => Type::nonNull(
                    Type::listOf(
                        $container->get(SelectedAttributeInputType::class)
                    )
                )],
            ],
        ]);
    }
}
