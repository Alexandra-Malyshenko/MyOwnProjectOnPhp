<?php

require 'autoloader.php';
use php\TemplateMaker;

$config = require '../Config/config.php';

$product_cakes = require '../Data/productsList.php';
$render = new TemplateMaker('mainPage', $config);
//$render->render(['headerTemplate','mainPageTemplate', 'footerTemplate'], 'mainPage', $product_cakes);
$render->render('categoryTemplate', 'categoryPage', $product_cakes);