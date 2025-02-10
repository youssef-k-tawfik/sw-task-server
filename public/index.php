<?php

declare(strict_types=1);

use App\Config\Container;
use App\Config\Doctrine;
use App\Utils\CustomLogger;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

require_once __DIR__ . '/../vendor/autoload.php';

CustomLogger::logInfo('Starting server');

// Loading environment variables
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); // for local development only
$dotenv->load();

// Initializing EntityManager
$entityManager = Doctrine::getEntityManager();

// Registering EntityManager
$container = new Container();
$container->set(EntityManagerInterface::class, $entityManager);
$container->set(EntityManager::class, $entityManager);

// Routing
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->post('/graphql', [App\Controller\GraphQL::class, 'handle']);
    $r->get("/", fn() => "Server is running"); // for server health check
});

$routeInfo = $dispatcher->dispatch(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "ERROR 404: Route Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "ERROR 405: Method Not Allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        echo $handler($vars);
        break;
}
