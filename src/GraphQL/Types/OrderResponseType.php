<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class OrderResponseType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'OrderResponse',
            'fields' => [
                'order_number' => [
                    'type' => Type::nonNull(Type::string())
                ],
            ],
        ]);
    }
}
