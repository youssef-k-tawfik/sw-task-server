<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class SelectedAttributeType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'SelectedAttribute',
            'fields' => [
                'id' => ['type' => Type::string()],
                'value' => ['type' => Type::string()],
            ],
        ]);
    }
}
