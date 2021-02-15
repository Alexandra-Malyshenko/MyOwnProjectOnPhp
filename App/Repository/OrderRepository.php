<?php

namespace App\Repository;

use App\models\Order;
use App\Tools\Database;
use App\tools\Errors\ProductsErrorException;
use PDO;

class OrderRepository
{
    public function getConnect(): PDO
    {
        return Database::getInstance()->getConnection();
    }

    public function getAll(): array
    {
        // get all information about all orders
        $sql = "SELECT id, user_id, address, price_total, created_at FROM orders";
        $statement = $this->getConnect()->query($sql);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Order');
        return $statement->fetchAll();
    }

    public function getAllByUserId(int $user_id): array
    {
        // get all information about all orders where user_id = $id
        $sql = "SELECT id, address, price_total, created_at FROM orders WHERE user_id = :user_id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['user_id' => $user_id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Order');
        return $statement->fetchAll();
    }

    public function getById(int $id): ?Order
    {
        if (empty($id)) {
            throw new ProductsErrorException('Must be enter an id for category');
        }
        // get all information about order where id = $id
        $sql = "SELECT id, address, price_total, created_at FROM orders WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Order');
        return $statement->fetch();
    }

    public function create($user_id, $address, $price_total): bool
    {
        $sql = "INSERT INTO orders (user_id, address, price_total) VALUE (:user_id, :address, :price_total)";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['user_id' => $user_id, 'address' => $address, 'price_total' => $price_total]);
        return true;
    }

    public function update(int $id, $user_id, $address, $price_total): bool
    {
        $sql = "UPDATE users SET (  user_id = :user_id
                                    address = :address, 
                                    price_total = :price_total) WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id, 'user_id' => $user_id, 'address' => $address, 'price_total' => $price_total]);
        return true;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM orders WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id]);
        return true;
    }

    public function getAllProductsByIdOrder(int $order_id): array
    {
        // get all products for order where id=$id
        $sql = "SELECT products.id, products.title, products.price 
                FROM products
                INNER JOIN products_order po on products.id = po.product_id
                WHERE po.order_id = :order_id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['order_id' => $order_id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Order');
        return $statement->fetchAll();
    }
}