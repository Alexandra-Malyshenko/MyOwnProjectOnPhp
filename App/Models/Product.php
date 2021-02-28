<?php

namespace App\models;

class Product
{
    private ?int $id;
    private ?int $category_id = null;
    private ?string $title;
    private ?int $price;
    private ?int $quantity;
    private ?string $description = null;
    private ?string $image = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setCategoryId(int $category_id): void
    {
        $this->category_id = $category_id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }
}