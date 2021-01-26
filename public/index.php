<?php

require 'autoloader.php';
use php\TemplateMaker;
use php\ProductsStock;

try {
    // include footer and header, and file of products
    $config = require '../Config/config.php';
    $products = require '../Data/productsList.php';

    // let's get uri string (custom routing)
    $path = trim($_SERVER['REQUEST_URI'], '/');

    // create ProductStock instants and pass here what category of products we want
    $stock = new ProductsStock($products["cakes"]);
    // when pass id number of product
    $product = $stock->getProduct(2);
    if ($product == false) {
        echo "There is no product by this id";
    }
    // create TemplateMaker instants and pass default layout with config file with path footer and header templates
    $render = new TemplateMaker($config);

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

    $render->render($path . 'Template', $layout . 'Page', $products);

} catch (\Exception $e) {
    echo $e;
}

