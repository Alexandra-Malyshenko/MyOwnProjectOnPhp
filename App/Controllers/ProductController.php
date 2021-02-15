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

    public function view(int $params)
    {
        $productObjectById = $this->productRepos->getById($params);
        $categoryObject = $this->categoryRepos->getById($productObjectById->getCategoryId());
        $render = new TemplateMaker();
        $render->render('', 'productPage', [
            $this->categoryRepos->getAll(),
            $categoryObject,
            $productObjectById
        ]);
    }
}
