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
    private $sort;
    private int $page;

    public function __construct()
    {
        $this->itemsOnPageCatalog = 6;
        $this->itemsOnPageCategory = 3;
        $this->logger = (new LoggerService())->getLogger();
        $this->categoryService = new CategoryService();
        $this->render = new TemplateMaker();
        $this->productService = new ProductService();
        $this->page = isset($_GET['page']) ? (int) $_GET['page'] : 1 ;
        $this->sort = isset($_GET['sort']) ? $_GET['sort'] : 'title-ASC';
    }

    public function index()
    {
        try {
            $pagination = (new Pagination(
                $this->page,
                $this->itemsOnPageCatalog,
                $this->productService
                    ->count()
            ));
            $this->render
                ->render(
                    '',
                    'categoryPage',
                    [$this->categoryService->getAll(), [], $pagination, new Sorting()]
                );
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }

    public function getCategory(int $id)
    {
        try {
            $sort = explode('-', $this->sort);
            $pagination = (new Pagination(
                $this->page,
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
                    'categoryByIdPage',
                    [
                        $this->categoryService->getAll(),
                        $category,
                        $products,
                        $pagination,
                        new Sorting()
                    ]
                );
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }

    public function getProductsAPI()
    {
        try {
            $sort = explode('-', $this->sort);
            $pagination = (new Pagination(
                $this->page,
                $this->itemsOnPageCatalog,
                $this->productService->count()
            ));
            $start = $pagination->getStart();
            echo json_encode(
                $this->productService
                ->getProductsJSON($start, $this->itemsOnPageCatalog, $sort),
                JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK
            );

        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }
}
