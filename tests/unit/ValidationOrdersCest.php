<?php

use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Services\OrderService;
use App\Services\UserService;

class ValidationOrdersCest
{
    protected OrderService $orderService;
    private UserService $userService;

    public function _before(UnitTester $I, libs\Database $database)
    {
        $host = 'localhost';
        $db_name = "proj_test";
        $userDB = 'proj_user';
        $passwordDB = 'Password1!';
        $this->db = new $database($host, $db_name, $userDB, $passwordDB);
        $this->userService = new UserService(new UserRepository($this->db));
        $this->orderService = new OrderService(new OrderRepository($this->db), $this->userService);
    }

    public function tryToTestGetOrderById(UnitTester $I)
    {
        $order = $this->orderService->getById(50);
        $I->assertObjectHasAttribute('user_id', $order);
        $I->seeInDatabase('orders', [
            'id' => $order->getId(),
            'user_id' => 1,
            'price_total' => $order->getPriceTotal(),
            'address' => $order->getAddress(),
            'contact_phone' => $order->getContactPhone()
        ]);
    }

    public function tryToTestGetProductsFromOrder(UnitTester $I)
    {
        $products = $this->orderService->getAllProductsByOrderId(50);
        $I->assertIsArray($products);
        $I->assertClassHasAttribute('category_id', \App\models\Product::class);
    }

    public function tryToTestCreatOrder(UnitTester $I)
    {
        $productObj = new \App\models\Product();
        $productObj->setId(5);
        $productObj->setCategoryId(1);
        $productObj->setTitle("Торт Настоящий шоколад");
        $productObj->setDescription('Это торт для сильных печенью. Его шоколадность зашкаливает. Мокрые шоко-коржи и крем на основе 70% бельгийского шоколада.
И да - это классическое сочетание не оставит равнодушным ни одного шокоголика 🍫🍫+орехи 50 грн / кг изделия+фрукты, сухофрукты 0 грн');
        $productObj->setPrice(390);
        $productObj->setImage("/images/category-page/6.jpg");
        $result = $this->orderService->create(
            'Lviv, Ivana Bogyna str., 34b',
            390,
            '0665385701',
            'Please, make with double peanuts',
            [5 => 1],
            [$productObj],
            5,
            '',
            ''
        );
        $I->haveInDatabase('orders', [
            "address" => 'Lviv, Ivana Bogyna str., 34b',
            "price_total" => 390,
            "contact_phone" => '0665385701',
            "comments" => 'Please, make with double peanuts'
        ]);
        $I->haveInDatabase('products_order', [
            'product_id' => $productObj->getId(),
            'order_id' => $this->orderService->getIdOfLastOrder()
        ]);
    }
}
