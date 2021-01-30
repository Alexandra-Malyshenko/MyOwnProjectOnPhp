<?php

use App\tools\TemplateMaker;
use App\models\Category;
use App\models\Product;

class CategoryController
{
    public function __construct()
    {
        $this->category = new Category();
        $this->product = new Product();

    }
    public function actionIndex()
    {
        $categoryList = $this->category->getCategoryList();
        $products = $this->product->getListOfProducts();

        // create TemplateMaker instants and pass default layout with config file with path footer and header templates
        $render = new TemplateMaker();
        $render->render( 'categoryTemplate','categoryPage', $products);

    }

    public function actionGetCategory($params)
    {
        $categoryById = $this->category->getCategoryById((int) $params[0]);
        $products = $this->product->getProductsByCategoryId($categoryById->id);

        // create TemplateMaker instants and pass default layout with config file with path footer and header templates
        $render = new TemplateMaker();
        $render->render( 'categoryTemplate','categoryPage', $products);

    }

}