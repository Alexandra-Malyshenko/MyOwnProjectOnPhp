<?php

use App\Services\CategoryService;
use App\Services\LoggerService;
use App\Services\SearchService;
use libs\Pagination;
use libs\Sorting;
use libs\TemplateMaker;

class SearchController
{
    private int $itemsOnPage;
    private $logger;
    private CategoryService $categoryService;
    private TemplateMaker $render;
    private int $page;
    private $sort;

    public function __construct()
    {
        $this->itemsOnPage = 6;
        $this->logger = (new LoggerService())->getLogger();
        $this->categoryService = new CategoryService();
        $this->render = new TemplateMaker();
    }

    public function index()
    {
        try {
            if (!empty($_POST)) {
                $searchText = $_POST['searchMe'];
                $products = (new SearchService())->search($searchText);
            }
            $this->render
                ->render(
                    '',
                    'searchPage',
                    [
                        $this->categoryService->getAll(),
                        [],
                        $products
                    ]
                );
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }
}
