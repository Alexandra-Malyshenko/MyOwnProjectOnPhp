<?php

namespace App\models;

class Comment
{
    private int $id;
    private string $text;
    private string $created_at;
    private int $user_id;
    private int $product_id;

    public function getId(): int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getDate(): string
    {
        return $this->created_at;
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

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setDate(string $date): void
    {
        $this->created_at = $date;
    }
}