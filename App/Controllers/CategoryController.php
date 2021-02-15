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

    public function index()
    {
        $categoryList = $this->categoryRepos->getAll();
        $products = $this->productRepos->getAll();
//        var_dump($products);

        // create TemplateMaker instants and pass default layout with config file with path footer and header templates
        $render = new TemplateMaker();
        $render->render('', 'categoryPage', [$categoryList,[], $products]);
    }

    public function getCategory(int $params)
    {
        $categoryObjectById = $this->categoryRepos->getById($params);
        $products = $this->productRepos->getByCategoryId($categoryObjectById->getId());

        // create TemplateMaker instants and pass default layout with config file with path footer and header templates
        $render = new TemplateMaker();
        $render->render('', 'categoryPage', [$this->categoryRepos->getAll(), $categoryObjectById, $products]);
    }
}
