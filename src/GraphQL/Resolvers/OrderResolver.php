<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers;

class OrderResolver
{
    public static function insertOrder($root, $args): array
    {
        return ["order_number" => $args['number']];
    }
}
