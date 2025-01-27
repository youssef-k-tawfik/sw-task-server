<?php

declare(strict_types=1);

namespace App\Config;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private static $container = [];

    public function get($id)
    {
        return self::$container[$id];
    }

    public function has($id): bool
    {
        return isset(self::$container[$id]);
    }
}
