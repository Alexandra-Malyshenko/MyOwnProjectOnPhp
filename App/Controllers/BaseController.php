<?php

namespace App\Controllers;

use App\Services\CartService;
use App\Services\CategoryService;
use App\Services\CommentService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\UserService;
use App\Services\WishListService;
use DI\Container;
use libs\Authentication;
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
        $container = new Container();
        $this->logger = $container->get('App\Services\LoggerService')->getLogger();
        $this->render = $container->get('libs\TemplateMaker');
        $this->prodService = $container->get('App\Services\ProductService');
        $this->userService = $container->get('App\Services\UserService');
        $this->orderService = $container->get('App\Services\OrderService');
        $this->commentService = $container->get('App\Services\CommentService');
        $this->wishListService = $container->get('App\Services\WishListService');
        $this->cartService = $container->get('App\Services\CartService');
        $this->categoryService = $container->get('App\Services\CategoryService');
        $this->authentication = $container->get('libs\Authentication');
    }
}