<?php

namespace App\models;

class Product
{
    private int $id;
    private int $category_id;
    private string $name;
    private int $price;
    private string $description;
    private string $image;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): string
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

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
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