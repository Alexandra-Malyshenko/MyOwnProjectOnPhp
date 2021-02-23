<?php

use App\Services\CategoryService;
use App\Services\CommentService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\WishListService;
use libs\Authentication;
use libs\Pagination;
use libs\TemplateMaker;

class CabinetController
{
    private TemplateMaker $render;
    private int $itemsOnPage;

    public function __construct()
    {
        $this->render = new TemplateMaker();
        $this->itemsOnPage = 6;
    }

    public function index()
    {
        $user = (new Authentication())->getUser();
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1 ;
        $pagination = (new Pagination($page, $this->itemsOnPage, (new OrderService())->count($user->getId())));
        $start = $pagination->getStart();
        $orders = (new OrderService())->getByUserId($user->getId(), $start, $this->itemsOnPage);
        $this->render->render('cabinetTemplate', 'cabinetPage', [(new CategoryService())->getAll(), $orders, $pagination]);
    }

    public function getOrder(int $id)
    {
        $order = (new OrderService())->getById($id);
        $products = (new OrderService())->getAllProducts($id);
        $this->render
            ->render('cabinetTemplate', 'cabinetOrderPage', [(new CategoryService())->getAll(), $order, $products]);
    }

    public function viewWishList()
    {
        $user = (new Authentication())->getUser();
        $wishList = (new WishListService())->getListByUserId($user->getId());
        $this->render
            ->render('cabinetTemplate', 'cabinetWishListPage', [(new CategoryService())->getAll(), $wishList]);
    }

    public function addWish(int $product_id)
    {
        $user = (new Authentication())->getUser();
        if ($user) {
            (new WishListService())->createWish($product_id, $user->getId());
            $referrer = $_SERVER['HTTP_REFERER'];
            header("Location: $referrer");
        }
    }

    public function deleteWish(int $id)
    {
        (new WishListService())->delete($id);
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }

    public function viewComments()
    {
        $user = (new Authentication())->getUser();
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1 ;
        $pagination = (new Pagination($page, $this->itemsOnPage, (new CommentService())->count($user->getId())));
        $start = $pagination->getStart();
        $commentList = (new CommentService())->getCommentsByUserId($user->getId(), $start, $this->itemsOnPage);
        $products = (new CommentService())->getProductsInComment($commentList);
        $this->render
            ->render(
                'cabinetTemplate',
                'cabinetCommentPage',
                [(new CategoryService())->getAll(), $commentList, $products, $pagination]
            );
    }

    public function deleteComment(int $id)
    {
        (new CommentService())->delete($id);
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }
}