<?php

use App\Core\Route\Router;
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

$response = $application->run();

if ($response) {
    echo $response;
}
