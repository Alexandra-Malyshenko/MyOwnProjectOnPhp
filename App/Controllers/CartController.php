<?php

use App\Services\CartService;
use App\Services\CategoryService;
use App\Services\LoggerService;
use App\Services\MailService;
use App\Services\OrderService;
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

    public function __construct()
    {
        $this->cartService = new CartService('');
        $this->orderService = new OrderService();
        $this->render = new TemplateMaker();
        $this->logger = LoggerService::getLogger();
        $this->categoryList = (new CategoryService())
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
                    [$this->categoryList, $products, $total]
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
        $user = (new Authentication())
            ->getUser();
        $result = false;
        if (!empty($_POST)) {
            $result = $this->post($productsFromSession, $products, $user, $total);
            if ($result) {
                (new MailService())
                    ->sendMessage('order', []);
                $this->cartService
                    ->clear();
            }
        }
        $this->render
            ->render(
                'cabinetTemplate',
                'checkoutPage',
                [$this->categoryList, $products, $total, $user, $result]
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