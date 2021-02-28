<?php

use App\Controllers\BaseController;
use App\Services\MailService;

class ProductController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function view(int $id)
    {
        try {
            $product = $this->prodService
                ->getProductById($id);
            $category = $this->categoryService
                ->getCategoryById($product->getCategoryId());
            $comments = $this->commentService
                ->getCommentsByProductId($product->getId());
            $users = $this->userService
                ->getUserByComments($comments);

            if (!empty($_POST)) {
                $user = $this->authentication
                    ->getUser();
                if ($this->post($user, $product->getId())) {
                    $referrer = $_SERVER['HTTP_REFERER'];
                    header("Location: $referrer");
                }
            }
            $this->render
                ->render(
                    '',
                    'productPage',
                    [
                        $this->categoryService->getAll(),
                        $category,
                        $product,
                        $comments,
                        $users,
                        $this->authentication,
                        $this->cartService,
                        $this->wishListService
                    ]
                );
        } catch (\Throwable $error) {
                $this->logger->warning($error->getMessage());
        }
    }

    public function post($user, $product_id)
    {
        try {
            $name = $_POST['name'];
            $product = (int) $_POST['productComment'];
            $text = $_POST['text'];
            if ($name == $user->getName()) {
                if (
                    $this->commentService
                    ->createComment($product_id, $user->getId(), $text)
                ) {
                    (new MailService($this->orderService))
                        ->sendMessage('auth', [$product_id]);
                    return true;
                }
            }
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }
}
