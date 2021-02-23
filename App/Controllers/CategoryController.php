<?php

use App\Services\CategoryService;
use App\Services\LoggerService;
use App\Services\ProductService;
use libs\TemplateMaker;
use libs\Pagination;
use libs\Sorting;
use Monolog\Logger;

class CategoryController
{
    private int $itemsOnPageCategory;
    private int $itemsOnPageCatalog;
    private TemplateMaker $render;
    private ProductService $productService;
    private CategoryService $categoryService;
    private Logger $logger;

    public function __construct()
    {
        $this->itemsOnPageCatalog = 6;
        $this->itemsOnPageCategory = 3;
        $this->logger = (new LoggerService())->getLogger();
        $this->categoryService = new CategoryService();
        $this->render = new TemplateMaker();
        $this->productService = new ProductService();
    }

    public function index()
    {
        try {
            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1 ;
            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'title-ASC';
            $sort = explode('-', $sort);
            $pagination = (new Pagination(
                $page,
                $this->itemsOnPageCatalog,
                $this->productService
                    ->count()
            ));
            $start = $pagination->getStart();
            $products = $this->productService
                ->getAll($start, $this->itemsOnPageCatalog, $sort);
            $this->render
                ->render(
                    '',
                    'categoryPage',
                    [$this->categoryService->getAll(), [], $products, $pagination, new Sorting()]
                );
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }

    public function getCategory(int $id)
    {
        try {
            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1 ;
            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'title-ASC';
            $sort = explode('-', $sort);
            $pagination = (new Pagination(
                $page,
                $this->itemsOnPageCategory,
                6
            ));
            $start = $pagination->getStart();
            $category = $this->categoryService
                ->getCategoryById($id);
            $products = $this->productService
                ->getByCategoryId(
                    $category->getId(),
                    $start,
                    $this->itemsOnPageCategory,
                    $sort
                );
            $this->render
                ->render(
                    '',
                    'categoryPage',
                    [
                        $this->categoryService->getAll(),
                        $category,
                        $products, $pagination,
                        new Sorting()
                    ]
                );
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }
}
