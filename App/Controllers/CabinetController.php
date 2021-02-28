<?php

use App\Controllers\BaseController;
use libs\Pagination;

class CabinetController extends BaseController
{
    private int $itemsOnPage;

    public function __construct()
    {
        parent::__construct();
        $this->itemsOnPage = 6;
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
                        $this->categoryService->getAll(),
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
                        $this->categoryService->getAll(),
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
                        $this->categoryService->getAll(),
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
                        $this->categoryService->getAll(),
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