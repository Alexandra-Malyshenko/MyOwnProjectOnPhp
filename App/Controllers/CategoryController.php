<?php

use App\tools\TemplateMaker;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;

class CategoryController
{
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepos;

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepos;

    public function __construct()
    {
        $this->categoryRepos = new CategoryRepository();
        $this->productRepos = new ProductRepository();
    }

    public function actionIndex()
    {
        $categoryList = $this->categoryRepos->getCategoryList();
        $products = $this->productRepos->getListOfProducts();

        // create TemplateMaker instants and pass default layout with config file with path footer and header templates
        $render = new TemplateMaker();
        $render->render('', 'categoryPage', [$categoryList,[], $products]);
    }

    public function actionGetCategory($params)
    {
        $categoryObjectById = $this->categoryRepos->getCategoryById((int) $params[0]);
        $products = $this->productRepos->getProductsByCategoryId($categoryObjectById->getId());

        // create TemplateMaker instants and pass default layout with config file with path footer and header templates
        $render = new TemplateMaker();
        $render->render('', 'categoryPage', [$this->categoryRepos->getCategoryList(), $categoryObjectById, $products]);
    }
}
