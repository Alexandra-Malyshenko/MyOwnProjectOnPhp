<?php

require 'autoloader.php';
use php\TemplateMaker;

try {
    $config = require '../Config/config.php';
    $products = require '../Data/productsList.php';

    $path = trim($_SERVER['REQUEST_URI'], '/');

    $render = new TemplateMaker('mainPage', $config);


//  Find out what layout we need :
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
    } else {
        $layout = $path;
    }

    $render->render($path . 'Template', $layout . 'Page', $products);

} catch (\Exception $e) {
    echo $e;
}

