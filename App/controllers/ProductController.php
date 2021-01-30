<?php

use App\models\ProductsStock;
use App\models\Product;
use App\tools\TemplateMaker;
use App\tools\logger\Logger;

class ProductController
{
    public function __construct()
    {
        $this->product = new Product();
    }
    public function actionView($params)
    {
        $logger = new Logger();
        $productById = $this->product->getProductById((int) $params[0]);
        // create TemplateMaker instants and pass default layout with config file with path footer and header templates
        $render = new TemplateMaker();
        $render->render( 'productTemplate','productPage', $productById);
    }
}