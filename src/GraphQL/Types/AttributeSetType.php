<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Config\Container;
use App\GraphQL\Resolvers\AttributeResolver;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class AttributeSetType extends ObjectType
{
    public function __construct()
    {
        $container = new Container();

        parent::__construct([
            'name' => 'AttributeSet',
            'fields' => [
                'id' => Type::nonNull(Type::string()),
                'name' => Type::nonNull(Type::string()),
                'type' => Type::nonNull(Type::string()),
                'items' => [
                    'type' => Type::listOf(Type::nonNull(new AttributeType())),
                    'resolve' => $container->get(AttributeResolver::class),
                    'getAttributes'
                ],
            ],
        ]);
    }
}
