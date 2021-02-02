<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//require '../autoloader.php';
require '../vendor/autoload.php';

use App\Tools\Errors\TemplateRenderException;
use App\Tools\Errors\ConfigException;
use App\Tools\Errors\PathException;
use App\Tools\Errors\ProductsErrorException;
use App\Tools\logger\Logger;
use App\Tools\Router;


$logger = new Logger();

try {
    $router = new Router();
    $router->run();

} catch (PathException $e) {
    $logger->warning($e->errorMessage());
    echo $e->errorMessage();
} catch (ConfigException $e) {
    $logger->warning($e->errorMessage());
    echo $e->errorMessage();
} catch (ProductsErrorException $e) {
    $logger->warning($e->errorMessage(), ["id" => $e->getId()]);
    echo $e->errorMessage();
} catch (TemplateRenderException $e) {
    $logger->warning($e->errorMessage());
    echo $e->errorMessage();
} catch (\Throwable $e) {
//    $logger->warning($e->errorMessage());
    echo $e->getMessage();
}

