<?php

use App\Services\CategoryService;
use App\Services\CommentService;
use App\Services\LoggerService;
use App\Services\MailService;
use App\Services\ProductService;
use App\Services\UserService;
use libs\Authentication;
use libs\TemplateMaker;
use Monolog\Logger;

class ProductController
{
    private ProductService $productService;
    private CategoryService $categoryService;
    private TemplateMaker $render;
    private CommentService $commentService;
    private Logger $logger;

    public function __construct()
    {
        $this->logger = (new LoggerService())->getLogger();
        $this->productService = new ProductService();
        $this->categoryService = new CategoryService();
        $this->render = new TemplateMaker();
        $this->commentService = new CommentService();
    }

    public function view(int $id)
    {
        try {
            $product = $this->productService
                ->getProductById($id);
            $category = $this->categoryService
                ->getCategoryById($product->getCategoryId());
            $comments = $this->commentService
                ->getCommentsByProductId($product->getId());
            $users = (new UserService())
                ->getUserByComments($comments);

            if (!empty($_POST)) {
                $user = (new Authentication())
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
                        $users
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
                    (new MailService())
                        ->sendMessage('auth', [$product_id]);
                    return true;
                }
            }
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }
}
