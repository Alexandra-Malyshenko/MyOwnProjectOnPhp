<?php

use App\Services\CartService;
use App\Services\CategoryService;
use App\Services\MailService;
use App\Services\OrderService;
use libs\TemplateMaker;
use libs\Authentication;

class CartController
{
    /**
     * @var CartService
     */
    private CartService $cartService;
    /**
     * @var OrderService
     */
    private OrderService $orderService;

    public function __construct()
    {
        $this->cartService = new CartService('');
        $this->orderService = new OrderService();
    }

    public function add(int $id): bool
    {
        $this->cartService->addProduct($id);
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }

    public function index()
    {
        $products = $this->cartService->getProducts();
        $total = $this->cartService->getTotalPrice($products);
        $render = new TemplateMaker();
        $render->render('cabinetTemplate', 'cartPage', [(new CategoryService())->getAll(),$products, $total]);
    }

    public function delete(int $id): bool
    {
        $this->cartService->deleteProduct($id);
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }

    public function checkout()
    {
        $productsFromSession = $this->cartService->getProductsFromSession();
        $products = $this->cartService->getProducts();
        $total = $this->cartService->getTotalPrice($products);
        $user = (new Authentication())->getUser();
        $result = false;
        if (!empty($_POST)) {
            $result = $this->post($productsFromSession, $products, $user, $total);
            if ($result) {
                (new MailService())->sendMessage('order');
                $this->cartService->clear();
            }
        }
        $render = new TemplateMaker();
        $render->render('cabinetTemplate', 'checkoutPage', [(new CategoryService())->getAll(),$products, $total, $user, $result]);
    }

    public function post($productsFromSession, $products, $user, $total)
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $comments = $_POST['comments'];
        return $this->orderService->create($address, $total, $phone, $comments,$productsFromSession, $products,$user->getId(), $name, $email);
    }
}