<?php

use App\Services\CategoryService;
use App\Services\CommentService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\WishListService;
use libs\Authentication;
use libs\TemplateMaker;

class CabinetController
{
    /**
     * @var TemplateMaker
     */
    private TemplateMaker $render;

    public function __construct()
    {
        $this->render = new TemplateMaker();
    }

    public function index()
    {
        $user = (new Authentication())->getUser();
        $orders = (new OrderService())->getByUserId($user->getId());
        $this->render->render('cabinetTemplate', 'cabinetPage', [(new CategoryService())->getAll(), $orders]);
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
        $commentList = (new CommentService())->getCommentsByUserId($user->getId());
        $products = (new CommentService())->getProductsInComment($commentList);
        $this->render
            ->render(
                'cabinetTemplate',
                'cabinetCommentPage',
                [(new CategoryService())->getAll(), $commentList, $products]
            );
    }

    public function deleteComment(int $id)
    {
        (new CommentService())->delete($id);
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }
}