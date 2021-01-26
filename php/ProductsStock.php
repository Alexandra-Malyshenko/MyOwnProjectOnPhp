<?php

namespace php;

class ProductsStock
{
    private $products;

    public function __construct(array $products = [])
    {
        $this->products = $products;
    }

    public function getProduct(int $id)
    {
        foreach ($this->products as $product) {
            if ($product["id"] == $id) {
                return $product;
            }
        }
    }
}