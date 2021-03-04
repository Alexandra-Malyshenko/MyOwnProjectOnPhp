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
use libs\ContainerDI;
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
        $builder = (new ContainerDI())->getContainer();
        $this->logger = $builder->get('Logger');
        $this->render = $builder->get('Render');
        $this->prodService = $builder->get('ProductService');
        $this->userService = $builder->get('UserService');
        $this->orderService = $builder->get('OrderService');
        $this->commentService = $builder->get('CommentService');
        $this->wishListService = $builder->get('WishListService');
        $this->cartService = $builder->get('CartService');
        $this->categoryService = $builder->get('CategoryService');
        $this->authentication = $builder->get('Authentication');
    }
}