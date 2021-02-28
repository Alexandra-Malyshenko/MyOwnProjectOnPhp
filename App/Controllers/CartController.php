<?php

use App\Repository\CategoryRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Repository\WishListRepository;
use App\Services\CartService;
use App\Services\CategoryService;
use App\Services\LoggerService;
use App\Services\MailService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\UserService;
use App\Services\WishListService;
use libs\Database;
use libs\Session;
use libs\TemplateMaker;
use libs\Authentication;
use Monolog\Logger;

class CartController
{
    private CartService $cartService;
    private OrderService $orderService;
    private TemplateMaker $render;
    private array $categoryList;
    private Logger $logger;
    private UserService $userService;
    private ProductService $prodService;
    private Authentication $authentication;
    private WishListService $wishListService;

    public function __construct()
    {
        $db = Database::getInstance()->getConnection();
        $session = new Session();
        $this->prodService = new ProductService(new ProductRepository($db));
        $this->userService = new UserService(new UserRepository($db));
        $this->cartService = new CartService('', $session, $this->prodService);
        $this->orderService = new OrderService(new OrderRepository($db), $this->userService);
        $this->render = new TemplateMaker();
        $this->logger = LoggerService::getLogger();
        $this->authentication = new Authentication($session, $this->userService);
        $this->wishListService = new WishListService(new WishListRepository($db), $this->prodService);
        $this->categoryList = (new CategoryService(new CategoryRepository($db)))
                                ->getAll();
    }

    public function add(int $id): bool
    {
        $this->cartService
            ->addProduct($id);
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }

    public function index()
    {
        try {
            $products = $this->cartService
                ->getProducts();
            $total = $this->cartService
                ->getTotalPrice($products);
            $this->render
                ->render(
                    'cabinetTemplate',
                    'cartPage',
                    [
                        $this->categoryList,
                        $products,
                        $total,
                        $this->authentication,
                        $this->cartService,
                        $this->wishListService,
                        $this->cartService->getProductsFromSession()
                    ]
                );
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }

    public function delete(int $id): bool
    {
        $this->cartService
            ->deleteProduct($id);
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }

    public function checkout()
    {
        $productsFromSession = $this->cartService
            ->getProductsFromSession();
        $products = $this->cartService
            ->getProducts();
        $total = $this->cartService
            ->getTotalPrice($products);
        $user = $this->authentication
            ->getUser();
        $result = false;
        if (!empty($_POST)) {
            $result = $this->post($productsFromSession, $products, $user, $total);
            if ($result) {
                (new MailService($this->orderService))
                    ->sendMessage('order', []);
                $this->cartService
                    ->clear();
            }
        }
        $this->render
            ->render(
                'cabinetTemplate',
                'checkoutPage',
                [
                    $this->categoryList,
                    $products,
                    $total,
                    $user,
                    $result,
                    $this->authentication,
                    $this->cartService,
                    $this->wishListService,
                    $this->cartService->getProductsFromSession()
                ]
            );
    }

    public function post($productsFromSession, $products, $user, $totalPrice)
    {
        try {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $comments = $_POST['comments'];
            return $this->orderService
                ->create(
                    $address,
                    $totalPrice,
                    $phone,
                    $comments,
                    $productsFromSession,
                    $products,
                    $user->getId(),
                    $name,
                    $email
                );
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }
}