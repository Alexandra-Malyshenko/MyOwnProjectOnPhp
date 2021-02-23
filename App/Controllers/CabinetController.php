<?php

use App\Services\CategoryService;
use App\Services\CommentService;
use App\Services\LoggerService;
use App\Services\OrderService;
use App\Services\WishListService;
use libs\Authentication;
use libs\Pagination;
use libs\TemplateMaker;
use Monolog\Logger;

class CabinetController
{
    private TemplateMaker $render;
    private int $itemsOnPage;
    private array $categoryList;
    private Authentication $authentication;
    private OrderService $orderService;
    private CommentService $commentService;
    private WishListService $wishListService;
    private Logger $logger;

    public function __construct()
    {
        $this->itemsOnPage = 6;
        $this->logger = LoggerService::getLogger();
        $this->render = new TemplateMaker();
        $this->authentication = new Authentication();
        $this->orderService = new OrderService();
        $this->commentService = new CommentService();
        $this->wishListService = new WishListService();
        $this->categoryList = (new CategoryService())
            ->getAll();
    }

    public function index()
    {
        try {
            $userID = $this->authentication
                ->getUser()
                ->getId();
            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1 ;
            $total = $this->orderService
                ->countOrderByUserId($userID);
            $pagination = new Pagination($page, $this->itemsOnPage, $total);
            $start = $pagination
                ->getStart();
            $orders = $this->orderService
                ->getByUserId($userID, $start, $this->itemsOnPage);
            $this->render
                ->render(
                    'cabinetTemplate',
                    'cabinetPage',
                    [$this->categoryList, $orders, $pagination]
                );
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }

    public function getOrder(int $id)
    {
        try {
            $order = $this->orderService
                ->getById($id);
            $products = $this->orderService
                ->getAllProductsByOrderId($id);
            $this->render
                ->render(
                    'cabinetTemplate',
                    'cabinetOrderPage',
                    [$this->categoryList, $order, $products]
                );
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }

    public function viewWishList()
    {
        try {
            $userID = $this->authentication
                ->getUser()
                ->getId();
            $wishList = $this->wishListService
                ->getListByUserId($userID);
            $this->render
                ->render(
                    'cabinetTemplate',
                    'cabinetWishListPage',
                    [$this->categoryList, $wishList]
                );
        } catch (\Throwable $error) {
                $this->logger->warning($error->getMessage());
        }
    }

    public function addWish(int $product_id)
    {
        try {
            $userID = $this->authentication
                ->getUser()
                ->getId();
            if ($userID) {
                $this->wishListService
                    ->createWish($product_id, $userID);
                $referrer = $_SERVER['HTTP_REFERER'];
                header("Location: $referrer");
            }
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }

    public function deleteWish(int $id)
    {
        $this->wishListService
             ->delete($id);
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }

    public function viewComments()
    {
        try {
            $userID = $this->authentication
                ->getUser()
                ->getId();
            $page = isset($_GET['page']) ? (int) $_GET['page'] : 1 ;
            $pagination = (new Pagination(
                $page,
                $this->itemsOnPage,
                $this->commentService->count($userID)
            ));
            $start = $pagination
                ->getStart();
            $commentList = $this->commentService
                ->getCommentsByUserId($userID, $start, $this->itemsOnPage);
            $products = $this->commentService
                ->getProductsInComment($commentList);
            $this->render
                ->render(
                    'cabinetTemplate',
                    'cabinetCommentPage',
                    [$this->categoryList, $commentList, $products, $pagination]
                );
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }

    public function deleteComment(int $id)
    {
        $this->commentService
             ->delete($id);
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }
}