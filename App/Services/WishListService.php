<?php

namespace App\Services;

use App\Repository\WishListRepository;
use App\Services\ProductService;

class WishListService
{
    private WishListRepository $wishListRepos;

    public function __construct()
    {
        $this->wishListRepos = new WishListRepository();
    }

    public function getListByUserId(int $user_id): array
    {
        $wishList = $this->wishListRepos
            ->getByUserId($user_id);
        $productsList = [];
        foreach ($wishList as $item) {
            $product = (new ProductService())
                ->getProductById($item->getProductId());
            $productsList[$item->getId()] = $product;
        }
        return $productsList;
    }

    public function getWishById(int $id)
    {
        return $this->wishListRepos
            ->getById($id);
    }

    public function createWish($product_id, $user_id): bool
    {
        return $this->wishListRepos
            ->create($product_id, $user_id);
    }

    public function updateWish(int $id, $product_id, $user_id): bool
    {
        return $this->wishListRepos
            ->update($id, $product_id, $user_id);
    }

    public function delete(int $id): bool
    {
        return $this->wishListRepos
            ->delete($id);
    }

    public function count(int $id): int
    {
        return count($this->wishListRepos
            ->getByUserId($id));
    }
}