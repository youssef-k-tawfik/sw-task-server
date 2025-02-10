<?php

declare(strict_types=1);

namespace App\Config;

use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\ORMSetup;

class Doctrine
{
    public static function getEntityManager(): EntityManager
    {

        $paths = [__DIR__ . '/../Entity'];

        $isDevMode = $_ENV['APP_ENV'] === 'development';

        $dbParams = [
            'driver'   => $_ENV['DB_DRIVER'],
            'host'     => $_ENV['DB_HOST'],
            'port'     => $_ENV['DB_PORT'],
            'user'     => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'dbname'   => $_ENV['DB_NAME'],
            'charset'  => 'utf8mb4',
        ];

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $paths,
            isDevMode: $isDevMode,
        );

        $connection = DriverManager::getConnection($dbParams);
        return new EntityManager($connection, $config);
    }
}
