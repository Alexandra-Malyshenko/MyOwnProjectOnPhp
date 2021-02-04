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

    public function actionView(int $params)
    {
        $productObjectById = $this->productRepos->getProductById($params);
        $categoryObject = $this->categoryRepos->getCategoryById($productObjectById->getCategoryId());
        $render = new TemplateMaker();
        $render->render('', 'productPage', [
            $this->categoryRepos->getCategoryList(),
            $categoryObject,
            $productObjectById
        ]);
    }
}
