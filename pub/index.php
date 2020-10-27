<?php

use App\Core\Exception\RouterException;
use App\Core\Routing\Router;
use App\Core\Application;

define('BP', dirname(__DIR__));

spl_autoload_register(function ($class) {
    $class = lcfirst($class);
    $filename = BP . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    if (file_exists($filename)) {
        require_once $filename;
    }
});

session_start();

$router = new Router();
$application = new Application($router);

try {
    $response = $application->run();
} catch (RouterException $e) {
    http_response_code(404);
    $response = '<h1>404 Not Found</h1>';
} catch (\Exception $e) {
    http_response_code(500);
    $response = '<h1>500 Internal Server Error</h1>';
}

if ($response) {
    echo $response;
}
