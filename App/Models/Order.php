<?php

namespace App\models;

class Order
{
    private int $id;
    private int $user_id;
    private string $address;
    private string $price_total;
    private array $products;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPriceTotal(): string
    {
        return $this->price_total;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function setTotalPrice(int $total_price): void
    {
        $this->price_total = $total_price;
    }

    public function setProducts(array $products): void
    {
        $this->products = $products;
    }
}