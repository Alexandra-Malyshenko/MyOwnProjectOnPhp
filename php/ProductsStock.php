<?php

namespace php;

use Errors\ProductsErrorException;

class ProductsStock
{
    private $products;

    public function __construct(array $products, $logger)
    {
        if (empty($products)) {
            $this->logger->warning('There is no array! You should pass array of products');
            throw new ProductsErrorException('There is no array! You should pass array of products');
        } else {
            $this->products = $products;
            $this->logger = $logger;
        }

    }

    public function getProduct(int $id = null)
    {
        if (empty($id)) {
            throw new ProductsErrorException('You pass no id');
        } elseif ($id > count($this->products)) {
            $this->logger->warning('There is no product by this id=', ["id" => $id]);
            throw new ProductsErrorException($id, 'There id no product by number id=');
        }
        foreach ($this->products as $product) {
            if ($product["id"] == $id) {
                return $product;
            }
        }
    }
}