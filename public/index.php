<?php

require 'autoloader.php';
use php\TemplateMaker;
use php\ProductsStock;

use Errors\TemplateRenderException;
use Errors\ConfigException;
use Errors\PathException;
use Errors\ProductsErrorException;

use php\logger\Logger;

$logger = new Logger();
$loggerName = new Logger("products");

try {
    // include footer and header templates from config, and file of products
    $config = require '../Config/config.php';
    $products = require '../Data/productsList.php';
    if (empty($config)) {

        throw new PathException('There is no configuration in this path');
    } elseif (empty($products)) {
        throw new PathException('There is no products file in this path');
    }

    // let's get uri string (custom routing)
    $path = trim($_SERVER['REQUEST_URI'], '/');

    // create ProductStock instants and pass here what category of products we want
    $stock = new ProductsStock($products["cakes"], $loggerName);
    // when pass id number of product
    $product = $stock->getProduct(1);

    // create TemplateMaker instants and pass default layout with config file with path footer and header templates
    $render = new TemplateMaker([]);

    //  Before render page we need to find out what layout we need :
    //   /      - main
    // login    - main
    // register - main
    // product  - product
    // category - category

    if ($path == '') {
        $path = 'main';
        $layout = 'main';
    } elseif ($path == 'login' or $path == 'register') {
        $layout = 'main';
    } elseif ($path == 'product') {
        $layout = $path;
        $products = $product;
    } else {
        $layout = $path;
    }

    $render->render($path . 'Template',$path . 'Page', $products);

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
    $logger->warning($e->errorMessage());
    echo $e->getMessage();
}

