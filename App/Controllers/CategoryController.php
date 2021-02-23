<?php

use App\Services\CategoryService;
use App\Services\ProductService;
use libs\TemplateMaker;
use libs\Pagination;

class CategoryController
{
    private int $itemsOnPageCategory;
    private int $itemsOnPageCatalog;

    public function __construct()
    {
        $this->itemsOnPageCatalog = 6;
        $this->itemsOnPageCategory = 3;
    }

    public function index()
    {
        $categoryList = (new CategoryService())->getAll();
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1 ;
        $pagination = (new Pagination($page, $this->itemsOnPageCatalog, (new ProductService())->count()));
        $start = $pagination->getStart();
        $products = (new ProductService())->getAll($start, $this->itemsOnPageCatalog);
        $render = new TemplateMaker();
        $render->render('', 'categoryPage', [$categoryList,[], $products, $pagination]);
    }

    public function getCategory(int $id)
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1 ;
        $pagination = (new Pagination($page, $this->itemsOnPageCategory, 6));
        $start = $pagination->getStart();
        $categoryObjectById = (new CategoryService())->getCategoryById($id);
        $products = (new ProductService())->getByCategoryId($categoryObjectById->getId(), $start, $this->itemsOnPageCategory);
        $render = new TemplateMaker();
        $render->render('', 'categoryPage', [(new CategoryService())->getAll(), $categoryObjectById, $products, $pagination]);
    }
}
