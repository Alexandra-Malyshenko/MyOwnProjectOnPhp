<?php

use App\Controllers\BaseController;
use libs\Pagination;
use libs\Sorting;

class CategoryController extends BaseController
{
    private int $itemsOnPageCategory;
    private int $itemsOnPageCatalog;
    private int $page;
    private $sort;

    public function __construct()
    {
        parent::__construct();
        $this->itemsOnPageCatalog = 6;
        $this->itemsOnPageCategory = 3;
        $this->page = isset($_GET['page']) ? (int) $_GET['page'] : 1 ;
        $this->sort = isset($_GET['sort']) ? $_GET['sort'] : 'title-ASC';
    }

    public function index()
    {
        try {
            $pagination = (new Pagination(
                $this->page,
                $this->itemsOnPageCatalog,
                $this->prodService
                    ->count()
            ));
            $this->render
                ->render(
                    '',
                    'categoryPage',
                    [
                        $this->categoryService->getAll(),
                        [],
                        $pagination,
                        new Sorting(),
                        $this->authentication,
                        $this->cartService,
                        $this->wishListService
                    ]
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
            $products = $this->prodService
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
                        new Sorting(),
                        $this->authentication,
                        $this->cartService,
                        $this->wishListService
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
                $this->prodService->count()
            ));
            $start = $pagination->getStart();
            echo json_encode(
                $this->prodService
                ->getProductsJSON($start, $this->itemsOnPageCatalog, $sort),
                JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK
            );

        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }
}
