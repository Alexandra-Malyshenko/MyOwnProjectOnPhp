<?php

namespace App\Controllers;

use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Repository\WishListRepository;
use App\Services\CartService;
use App\Services\CategoryService;
use App\Services\CommentService;
use App\Services\LoggerService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\UserService;
use App\Services\WishListService;
use libs\Authentication;
use libs\Database;
use libs\Session;
use libs\TemplateMaker;
use Monolog\Logger;

class BaseController
{
    protected Logger $logger;
    /**
     * @var TemplateMaker
     */
    protected TemplateMaker $render;
    /**
     * @var ProductService
     */
    protected ProductService $prodService;
    /**
     * @var UserService
     */
    protected UserService $userService;
    /**
     * @var OrderService
     */
    protected OrderService $orderService;
    /**
     * @var CommentService
     */
    protected CommentService $commentService;
    /**
     * @var WishListService
     */
    protected WishListService $wishListService;
    /**
     * @var CartService
     */
    protected CartService $cartService;
    /**
     * @var CategoryService
     */
    protected CategoryService $categoryService;
    /**
     * @var Authentication
     */
    protected Authentication $authentication;

    public function __construct()
    {
        $db = Database::getInstance()->getConnection();
        $session = new Session();
        $this->logger = LoggerService::getLogger();
        $this->render = new TemplateMaker();
        $this->prodService = new ProductService(new ProductRepository($db));
        $this->userService = new UserService(new UserRepository($db));
        $this->orderService = new OrderService(new OrderRepository($db), $this->userService);
        $this->commentService = new CommentService(new CommentRepository($db), $this->prodService);
        $this->wishListService = new WishListService(new WishListRepository($db), $this->prodService);
        $this->cartService = new CartService($session, $this->prodService);
        $this->categoryService = new CategoryService(new CategoryRepository($db));
        $this->authentication = new Authentication($session, $this->userService);
    }
}