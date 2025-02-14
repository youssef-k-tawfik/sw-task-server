<?php

declare(strict_types=1);

namespace App\Config;

use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface
{
    private static $container = [];

    public function get(string $id)
    {
        if ($this->has($id)) {
            return self::$container[$id];
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset(self::$container[$id]);
    }

    public function set(string $id, $value): void
    {
        self::$container[$id] = $value;
    }

    private function resolve(string $id)
    {
        try {
            $reflectionClass = new ReflectionClass($id);

            if (!$reflectionClass->isInstantiable()) {
                throw new ReflectionException("Class {$id} is not instantiable");
            }

            $constructor = $reflectionClass->getConstructor();

            if (is_null($constructor)) {
                $object = new $id;
                $this->set($id, $object);
                return $object;
            }

            $parameters = $constructor->getParameters();

            if (empty($parameters)) {
                $object = new $id;
                $this->set($id, $object);
                return $object;
            }

            $dependencies = $this->extractDependencies($parameters, $id);

            $object = $reflectionClass->newInstanceArgs($dependencies);
            $this->set($id, $object);

            return $object;
        } catch (ReflectionException $e) {
            throw new \Exception("Unable to resolve {$id}: " . $e->getMessage());
        }
    }

    private function extractDependencies(array $parameters, string $id): array
    {
        return array_map(
            function (\ReflectionParameter $parameter) use ($id) {

                $name = $parameter->getName();
                $type = $parameter->getType();

                if ($type === null) {
                    throw new ReflectionException(
                        "Missing type hint for {$name} in {$id}"
                    );
                }

                $classType = $type->getName();
                if (
                    !$type->isBuiltin()
                    && $type instanceof \ReflectionNamedType
                ) {
                    if ($classType === self::class) {
                        return $this;
                    }
                    return $this->get($classType);
                }

                throw new ReflectionException(
                    "Invalid parameter {$name} in {$id}"
                );
            },
            $parameters
        );
    }
}
