<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Price;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class CurrencyType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Currency',
            'fields' => [
                'symbol' =>  Type::nonNull(Type::string()),
                'label' =>  Type::nonNull(Type::string()),
            ],
        ]);
    }
}
