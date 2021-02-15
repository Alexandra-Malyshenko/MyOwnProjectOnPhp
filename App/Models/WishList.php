<?php

namespace App\models;

class WishList
{
    private int $id;
    private int $user_id;
    private int $product_id;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }
}