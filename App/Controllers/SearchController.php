<?php

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Repository\WishListRepository;
use App\Services\CartService;
use App\Services\CategoryService;
use App\Services\LoggerService;
use App\Services\ProductService;
use App\Services\SearchService;
use App\Services\UserService;
use App\Services\WishListService;
use libs\Authentication;
use libs\Database;
use libs\Session;
use libs\TemplateMaker;

class SearchController
{
    private int $itemsOnPage;
    private $logger;
    private CategoryService $categoryService;
    private TemplateMaker $render;
    private ProductService $prodService;
    private UserService $userService;
    private WishListService $wishListService;
    private Authentication $authentication;
    private CartService $cartService;

    public function __construct()
    {
        $db = Database::getInstance()->getConnection();
        $session = new Session();
        $this->itemsOnPage = 6;
        $this->logger = (new LoggerService())->getLogger();
        $this->categoryService = new CategoryService(new CategoryRepository($db));
        $this->render = new TemplateMaker();
        $this->prodService = new ProductService(new ProductRepository($db));
        $this->userService = new UserService(new UserRepository($db));
        $this->wishListService = new WishListService(new WishListRepository($db), $this->prodService);
        $this->authentication = new Authentication($session, $this->userService);
        $this->cartService = new CartService('', $session, $this->prodService);
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
