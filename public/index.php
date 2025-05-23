<?php

declare(strict_types=1);

// use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use App\Config\Container;
use App\Config\Doctrine;
use App\Utils\CustomLogger;

require_once __DIR__ . '/../vendor/autoload.php';


error_reporting(E_ALL); // ! development only
ini_set('display_errors', 1); // ! development only

CustomLogger::logInfo('Starting server');
CustomLogger::logInfo("Requested method: " . $_SERVER['REQUEST_METHOD']);

$allowed_domains = [
    'https://sw-task-client.yousseftawfik.com',
    'http://localhost:5173', // ! development only
    'localhost:8000', // ! development only
];

// Get the Origin of the incoming request
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
CustomLogger::logInfo("Requesting origin: $origin");

// development only
$host = $_SERVER['HTTP_HOST'] ?? '';
CustomLogger::logInfo("Requesting host: $host");

// Check if the origin is in the list of allowed domains
if (in_array($origin, $allowed_domains) || in_array($host, $allowed_domains)) {
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header('content-type: application/json; charset=utf-8');
} else {
    http_response_code(403);
    echo "403 Forbidden - This origin is not allowed.";
    exit();
}

// Handle preflight requests (OPTIONS method)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // No Content
    exit;
}

// Loading environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Initialize Container
$container = new Container();

// Register EntityManager with the container
$entityManager = Doctrine::getEntityManager();
$container->set(EntityManagerInterface::class, $entityManager);

// Create and register the Validator with the container
$validator = Validation::createValidator();
$container->set(ValidatorInterface::class, $validator);

// Routing
$dispatcher = FastRoute\simpleDispatcher(
    function (FastRoute\RouteCollector $r) use ($container) {
        $r->post('/graphql', function () use ($container) {
            return \App\Controller\GraphQL::handle($container);
        });
        $r->get("/", fn() => "Server is running"); // for server health check
    }
);

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
