<?php

use App\Services\CategoryService;
use App\Services\CommentService;
use App\Services\MailService;
use App\Services\ProductService;
use App\Services\UserService;
use libs\Authentication;
use libs\TemplateMaker;

class ProductController
{
    public function view(int $params)
    {
        $productObjectById = (new ProductService())->getProductById($params);
        $categoryObject = (new CategoryService())->getCategoryById($productObjectById->getCategoryId());
        $comments = (new CommentService())->getCommentsByProductId($productObjectById->getId());
        $users = (new UserService())->getUserByComments($comments);

        if (!empty($_POST)) {
            $user = (new Authentication())->getUser();
            if ($this->post($user, $productObjectById->getId())) {
                $referrer = $_SERVER['HTTP_REFERER'];
                header("Location: $referrer");
            }
        }

        $render = new TemplateMaker();
        $render->render('', 'productPage', [
            (new CategoryService())->getAll(),
            $categoryObject,
            $productObjectById,
            $comments,
            $users
        ]);
    }

    public function post($user, $product_id)
    {
        $name = $_POST['name'];
        $product = (int) $_POST['productComment'];
        $text = $_POST['text'];
        if ($name == $user->getName()) {
            if ((new CommentService())->createComment($product_id, $user->getId(), $text)) {
                (new MailService())->sendMessage('auth', [$product]);
                return true;
            }
        }
    }
}
