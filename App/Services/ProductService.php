<?php

namespace App\Services;


use App\Repository\ProductRepository;

class ProductService
{
    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepos;

    public function __construct()
    {
        $this->productRepos = new ProductRepository();
    }

    public function getProductById(int $id)
    {
        return $this->productRepos->getById($id);
    }

    public function getAll(): array
    {
        return $this->productRepos->getAll();
    }

    public function getByCategoryId(int $id): array
    {
        return $this->productRepos->getByCategoryId($id);
    }

    public function createProduct(int $category_id, string $title, int $price, string $description, string $image): bool
    {
        return $this->productRepos->create($category_id, $title, $price, $description, $image);
    }

    public function updateProduct(int $id, int $category_id, string $title, int $price, string $description, string $image): bool
    {
        return $this->productRepos->update($id, $category_id, $title, $price, $description, $image);
    }

    public function deleteProduct(int $id): bool
    {
        return $this->productRepos->delete($id);
    }
}