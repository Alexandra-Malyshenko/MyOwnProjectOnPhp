<?php

namespace App\Services;

use App\Repository\OrderRepository;
use App\tools\Errors\ProductsErrorException;

class OrderService
{
    private OrderRepository $orderRepos;
    private UserService $userService;

    public function __construct($orderRepos, $userService)
    {
        $this->orderRepos = $orderRepos;
        $this->userService = $userService;
    }

    public function getByUserId(int $id, int $start, int $itemsOnPage): array
    {
        if (empty($id)) {
            throw new ProductsErrorException('Must be enter an id for category');
        }
        return $this->orderRepos->getAllByUserId($id, $start, $itemsOnPage);
    }

    public function getById(int $id)
    {
        if (empty($id)) {
            throw new ProductsErrorException('Must be enter an id for category');
        }
        return $this->orderRepos->getById($id);
    }

    public function getAllProductsByOrderId(int $id): array
    {
        return $this->orderRepos->getAllProductsByIdOrder($id);
    }

    public function createOrderProducts($productsFromSession, $productsFromCart, $order_id): bool
    {
        foreach ($productsFromCart as $product) {
            $this->orderRepos->createAllProductsByIdOrder($product->getId(), $order_id, $productsFromSession[$product->getId()]);
        }
        return true;
    }

    public function create(
        string $address,
        int $price_total,
        string $contact_phone,
        string $comments,
        array $productsFromSession,
        array $productsFromCart,
        int $user_id = null,
        string $user_name = null,
        string $user_email = null
    ): bool {
        $this->orderRepos
            ->create($user_id, $user_name, $user_email, $address, $price_total, $contact_phone, $comments);
        $orderId = $this->orderRepos->getLastId();
        return $this->createOrderProducts($productsFromSession, $productsFromCart, $orderId);
    }

    public function update(
        int $id,
        int $user_id,
        string $address,
        int $price_total,
        string $contact_phone,
        string $comments
    ): bool {
        return ($this->orderRepos
            ->update($id, $user_id, $address, $price_total, $contact_phone, $comments));
    }

    public function delete(int $id): string
    {
        if (empty($id)) {
            throw new ProductsErrorException('Must be enter an id for category');
        }
        return $this->orderRepos->delete($id);
    }

    public function getIdOfLastOrder(): int
    {
        return $this->orderRepos->getLastId();
    }

    public function countOrderByUserId(int $id): int
    {
        return (int) $this->orderRepos->count($id);
    }
}