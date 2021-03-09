<?php

namespace App\Services;

use App\Repository\ProductRepository;
use App\Resources\ProductResource;

class ProductService
{
    private ProductRepository $productRepos;

    public function __construct(ProductRepository $productRepos)
    {
        $this->productRepos = $productRepos;
    }

    public function getProductById(int $id)
    {
        return $this->productRepos
            ->getById($id);
    }

    public function getAll(int $start, int $itemsOnPage, array $sort): array
    {
        $whatOrder = $sort[0];
        $howOrder = $sort[1];
        return $this->productRepos
            ->getAll($start, $itemsOnPage, $whatOrder, $howOrder);
    }

    public function getByCategoryId(int $id, int $start, int $itemsOnPage, $sort): array
    {
        $whatOrder = $sort[0];
        $howOrder = $sort[1];
        return $this->productRepos
            ->getByCategoryId($id, $start, $itemsOnPage, $whatOrder, $howOrder);
    }

    public function createProduct(
        int $category_id,
        string $title,
        int $price,
        string $description,
        string $image
    ): bool {
        return $this->productRepos
            ->create($category_id, $title, $price, $description, $image);
    }

    public function updateProduct(
        int $id,
        int $category_id,
        string $title,
        int $price,
        string $description,
        string $image
    ): bool {
        return $this->productRepos
            ->update($id, $category_id, $title, $price, $description, $image);
    }

    public function deleteProduct(int $id): bool
    {
        return $this->productRepos
            ->delete($id);
    }

    public function count(): int
    {
        return (int) $this->productRepos
            ->count();
    }

    public function searchProducts(string $keyword): array
    {
        return $this->productRepos
            ->search($keyword);
    }

    public function getProductsJSON(int $start, int $itemsOnPage, array $sort): array
    {
        $products = $this->getAll($start, $itemsOnPage, $sort);
        return (new ProductResource())->toArrayCollection($products);
    }
}