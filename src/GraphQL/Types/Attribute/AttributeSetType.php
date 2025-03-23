<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Attribute;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

use App\Config\Container;

class AttributeSetType extends ObjectType
{
    public function __construct(Container $container)
    {
        parent::__construct([
            'name' => 'AttributeSet',
            'fields' => [
                'id' => Type::nonNull(Type::string()),
                'name' => Type::nonNull(Type::string()),
                'type' => Type::nonNull(Type::string()),
                'items' =>  Type::listOf(
                    Type::nonNull(
                        $container->get(AttributeType::class)
                    )
                )
            ],
        ]);
    }
}
