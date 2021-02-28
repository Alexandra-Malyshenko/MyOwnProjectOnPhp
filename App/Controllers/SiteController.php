<?php

use App\Controllers\BaseController;

class SiteController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $this->render
                ->render(
                    'mainTemplate',
                    'mainPage',
                    [
                        $this->categoryService->getAll(),
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
