<?php

use App\Services\CategoryService;
use App\Services\ProductService;
use App\tools\TemplateMaker;

class CategoryController
{
    public function index()
    {
        $categoryList = (new CategoryService())->getAll();
        $products = (new ProductService())->getAll();
        $render = new TemplateMaker();
        $render->render('', 'categoryPage', [$categoryList,[], $products]);
    }

    public function getCategory(int $id)
    {
        $categoryObjectById = (new CategoryService())->getCategoryById($id);
        $products = (new ProductService())->getByCategoryId($categoryObjectById->getId());
        $render = new TemplateMaker();
        $render->render('', 'categoryPage', [(new CategoryService())->getAll(), $categoryObjectById, $products]);
    }
}
