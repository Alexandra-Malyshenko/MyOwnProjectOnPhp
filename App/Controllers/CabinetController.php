<?php

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
use libs\Pagination;
use libs\Session;
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
    private ProductService $prodService;
    private UserService $userService;
    private CartService $cartService;

    public function __construct()
    {
        $db = Database::getInstance()->getConnection();
        $session = new Session();
        $this->itemsOnPage = 6;
        $this->logger = LoggerService::getLogger();
        $this->render = new TemplateMaker();
        $this->prodService = new ProductService(new ProductRepository($db));
        $this->userService = new UserService(new UserRepository($db));
        $this->orderService = new OrderService(new OrderRepository($db), $this->userService);
        $this->commentService = new CommentService(new CommentRepository($db), $this->prodService);
        $this->wishListService = new WishListService(new WishListRepository($db), $this->prodService);
        $this->authentication = new Authentication($session, $this->userService);
        $this->cartService = new CartService('', $session, $this->prodService);
        $this->categoryList = (new CategoryService(new CategoryRepository($db)))
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
                    [
                        $this->categoryList,
                        $orders,
                        $pagination,
                        $this->authentication,
                        $this->cartService,
                        $this->wishListService
                    ]
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
                    [
                        $this->categoryList,
                        $order,
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
                    [
                        $this->categoryList,
                        $wishList,
                        $this->authentication,
                        $this->cartService,
                        $this->wishListService
                    ]
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
                    [
                        $this->categoryList,
                        $commentList,
                        $products,
                        $pagination,
                        $this->authentication,
                        $this->cartService,
                        $this->wishListService
                    ]
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