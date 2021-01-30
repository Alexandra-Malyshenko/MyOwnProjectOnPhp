<?php


//session_save_path(__DIR__ . '/../App/storage/php-session/');
//session_start();
//exit();

require '../autoloader.php';
use App\tools\TemplateMaker;
use App\models\ProductsStock;
use App\tools\Errors\TemplateRenderException;
use App\tools\Errors\ConfigException;
use App\tools\Errors\PathException;
use App\tools\Errors\ProductsErrorException;
use App\tools\logger\Logger;
use App\tools\Router;


$logger = new Logger();
$loggerName = new Logger("products");


try {
    // include footer and header templates from config, and file of products
//    $config = require '../App/config/config.php';
//    $products = require '../App/models/productsList.php';
//    if (empty($config)) {
//
//        throw new PathException('There is no configuration in this path');
//    } elseif (empty($products)) {
//        throw new PathException('There is no products file in this path');
//    }


    // create ProductStock instants and pass here what category of products we want
//    $stock = new ProductsStock($products["cakes"], $loggerName);
    // when pass id number of product
//    $product = $stock->getProduct(1);
    // create TemplateMaker instants and pass default layout with config file with path footer and header templates



    $router = new Router();
    $router->run();

} catch (PathException $e) {
    $logger->warning($e->errorMessage());
    echo $e->errorMessage();
} catch (ConfigException $e) {
    $logger->warning($e->errorMessage());
    echo $e->errorMessage();
} catch (ProductsErrorException $e) {
//    $logger->warning($e->errorMessage(), ["id" => $e->getId()]);
    echo $e->errorMessage();
} catch (TemplateRenderException $e) {
    $logger->warning($e->errorMessage());
    echo $e->errorMessage();
} catch (\Throwable $e) {
//    $logger->warning($e->errorMessage());
    echo $e->getMessage();
}

