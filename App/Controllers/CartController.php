<?php

use App\Controllers\BaseController;
use App\Services\MailService;

class CartController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
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
                        $this->categoryService->getAll(),
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
        $productsFromCart = $this->cartService
            ->getProducts();
        $total = $this->cartService
            ->getTotalPrice($productsFromCart);
        $user = $this->authentication
            ->getUser();
        $result = false;
        if (!empty($_POST)) {
            $result = $this->post($productsFromSession, $productsFromCart, $user, $total);
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
                    $this->categoryService->getAll(),
                    $productsFromCart,
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

    public function post($productsFromSession, $productsFromCart, $user, $totalPrice)
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
                    $productsFromCart,
                    $user->getId(),
                    $name,
                    $email
                );
        } catch (\Throwable $error) {
            $this->logger->warning($error->getMessage());
        }
    }
}