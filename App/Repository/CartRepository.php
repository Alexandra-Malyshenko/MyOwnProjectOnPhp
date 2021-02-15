<?php

namespace App\Repository;

use App\Tools\Session;
use App\Repository\ProductRepository;

class CartRepository
{
    /**
     * @var Session
     */
    private Session $session;
    private string $sessionKey;

    public function __construct(string $path)
    {
        $this->session = new Session();
        if ($path == null) {
            $this->session->setSavePath(__DIR__ . '/../storage/php-session/');
        } else {
            $this->session->setSavePath($path);
        }
        $this->sessionKey = 'products';
    }

    public function addProduct(int $id): void
    {
        $this->session->start();
        if ($this->session->contains($this->sessionKey)) {
            $productsCart = $this->session->get($this->sessionKey);
        } else {
            $productsCart = [];
        }

        if (array_key_exists($id, $productsCart)) {
            $productsCart[$id] ++;
        } else {
            $productsCart[$id] = 1;
        }

        $this->session->set($this->sessionKey, $productsCart);
    }

    public function deleteProduct(int $id): void
    {
        $this->session->start();
        if ($this->session->contains($this->sessionKey)) {
            $productsCart = $this->session->get($this->sessionKey);
        } else {
            $productsCart = [];
        }
        unset($productsCart[$id]);
        $this->session->set($this->sessionKey, $productsCart);
    }

    public function countItems(): int
    {
        $this->session->start();
        if ($this->session->contains($this->sessionKey)) {
            $count = 0;
            foreach ($this->session->get($this->sessionKey) as $id => $quantity) {
                $count += $quantity;
            }
            return $count;
        } else {
            return 0;
        }
    }

    public function getProductsFromSession(): array
    {
        $this->session->start();
        if ($this->session->contains($this->sessionKey)) {
            return $this->session->get($this->sessionKey);
        }
        return [];
    }

    public function getTotalPrice(array $products): int
    {
        $productsFromSession = $this->getProductsFromSession();
        $total = 0;

        foreach ($products as $product) {
            $total += $product->getPrice() * $productsFromSession[$product->getId()];
        }
        return $total;
    }

    public function getProducts(): array
    {
        $productsID = array_keys($this->getProductsFromSession());
        $productsList = [];
        $productRepos = new ProductRepository();
        foreach ($productsID as $id) {
            array_push($productsList, $productRepos->getById($id));
        }
        return $productsList;
    }

}