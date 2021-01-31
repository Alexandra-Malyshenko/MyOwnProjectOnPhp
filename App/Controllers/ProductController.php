<?php

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\tools\TemplateMaker;

class ProductController
{
    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepos;

    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepos;

    public function __construct()
    {
        $this->productRepos = new ProductRepository();
        $this->categoryRepos = new CategoryRepository();
    }

    public function actionView($params)
    {
        $productObjectById = $this->productRepos->getProductById((int) $params[0]);
        $categoryObject = $this->categoryRepos->getCategoryById($productObjectById->getCategoryId());
        // create TemplateMaker instants and pass default layout with config file with path footer and header templates
        $render = new TemplateMaker();
        $render->render( '','productPage', [$categoryObject, $productObjectById]);
    }
}