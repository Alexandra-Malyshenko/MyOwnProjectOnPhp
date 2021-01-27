<?php

namespace php;

use Errors\ProductsErrorException;

class ProductsStock
{
    private $products;

    public function __construct(array $products = [])
    {
        if (empty($products)) {
            throw new ProductsErrorException('There is no array! You should pass array of products');
        } else {
            $this->products = $products;
        }

    }

    public function getProduct(int $id = null)
    {
        if (empty($id)) {
            throw new ProductsErrorException('Missing id number');
        }
        foreach ($this->products as $product) {
            if ($product["id"] == $id) {
                return $product;
            }
        }
    }
}