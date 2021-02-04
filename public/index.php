<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require '../vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Tools\Router;

$logger = new Logger("my-logger");
$logger->pushHandler(new StreamHandler(__DIR__ . '/../App/storage/log/error.log', Logger::WARNING));

try {
    $router = new Router();
    $router->run();
} catch (\Throwable $e) {
    $logger->warning($e->getMessage());
    echo $e->getMessage();
}

