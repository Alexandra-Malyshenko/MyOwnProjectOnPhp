<?php

use App\Controllers\BaseController;
use App\Services\SearchService;

class SearchController extends BaseController
{
    private int $itemsOnPage;

    public function __construct()
    {
        $this->itemsOnPage = 6;
        parent::__construct();
    }

    public function index()
    {
        try {
            $products = [];
            if (!empty($_POST)) {
                $searchText = $_POST['searchMe'];
                $products = (new SearchService($this->prodService))->search($searchText);
            }
            $this->render
                ->render(
                    '',
                    'searchPage',
                    [
                        $this->categoryService->getAll(),
                        [],
                        $products,
                        $this->authentication,
                        $this->cartService,
                        $this->wishListService
                    ]
                );
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }
}
