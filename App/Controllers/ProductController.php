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
use App\Services\MailService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\UserService;
use App\Services\WishListService;
use libs\Authentication;
use libs\Database;
use libs\Session;
use libs\TemplateMaker;
use Monolog\Logger;

class ProductController
{
    private ProductService $productService;
    private CategoryService $categoryService;
    private TemplateMaker $render;
    private CommentService $commentService;
    private Logger $logger;
    private UserService $userService;
    private Authentication $authentication;
    private WishListService $wishListService;
    private CartService $cartService;
    private OrderService $orderService;

    public function __construct()
    {
        $db = Database::getInstance()->getConnection();
        $session = new Session();
        $this->logger = (new LoggerService())->getLogger();
        $this->productService = new ProductService(new ProductRepository($db));
        $this->categoryService = new CategoryService(new CategoryRepository($db));
        $this->render = new TemplateMaker();
        $this->commentService = new CommentService(new CommentRepository($db), $this->productService);
        $this->userService = new UserService(new UserRepository($db));
        $this->orderService = new OrderService(new OrderRepository($db), $this->userService);
        $this->authentication = new Authentication($session, $this->userService);
        $this->wishListService = new WishListService(new WishListRepository($db), $this->productService);
        $this->cartService = new CartService('', $session, $this->productService);
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
