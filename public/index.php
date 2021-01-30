<?php


//session_save_path(__DIR__ . '/../App/storage/php-session/');
//session_start();
//exit();

require '../autoloader.php';

use App\tools\Errors\TemplateRenderException;
use App\tools\Errors\ConfigException;
use App\tools\Errors\PathException;
use App\tools\Errors\ProductsErrorException;
use App\tools\logger\Logger;
use App\tools\Router;


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
    $logger->warning($e->errorMessage());
    echo $e->getMessage();
}

