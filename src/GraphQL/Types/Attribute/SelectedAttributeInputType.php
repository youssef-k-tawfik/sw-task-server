<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Attribute;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class SelectedAttributeInputType extends InputObjectType
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
