<?php

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Repository\WishListRepository;
use App\Services\CartService;
use App\Services\CategoryService;
use App\Services\LoggerService;
use App\Services\ProductService;
use App\Services\UserService;
use App\Services\WishListService;
use libs\Authentication;
use libs\Database;
use libs\Session;
use libs\TemplateMaker;
use Monolog\Logger;

class SiteController
{
    private Logger $logger;
    private array $categoryList;
    private ProductService $prodService;
    private UserService $userService;
    private WishListService $wishListService;
    private Authentication $authentication;
    private CartService $cartService;

    public function __construct()
    {
        $db = Database::getInstance()->getConnection();
        $session = new Session();
        $this->logger = (new LoggerService())->getLogger();
        $this->prodService = new ProductService(new ProductRepository($db));
        $this->userService = new UserService(new UserRepository($db));
        $this->wishListService = new WishListService(new WishListRepository($db), $this->prodService);
        $this->authentication = new Authentication($session, $this->userService);
        $this->cartService = new CartService('', $session, $this->prodService);
        $this->categoryList = (new CategoryService(new CategoryRepository($db)))
            ->getAll();
    }

    public function index()
    {
        try {
            (new TemplateMaker())
                ->render(
                    'mainTemplate',
                    'mainPage',
                    [
                        $this->categoryList,
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
