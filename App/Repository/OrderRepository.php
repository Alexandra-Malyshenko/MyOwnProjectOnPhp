<?php

namespace App\Repository;

use App\models\Order;
use App\models\Product;
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
        $sql = "SELECT id, user_id, address, price_total, contact_phone, comments, created_at 
                FROM orders";
        $statement = $this->getConnect()->query($sql);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Order');
        return $statement->fetchAll();
    }

    public function getAllByUserId(int $user_id): array
    {
        // get all information about all orders where user_id = $id
        $sql = "SELECT id, address, price_total, contact_phone, comments, created_at 
                FROM orders 
                WHERE user_id = :user_id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['user_id' => $user_id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Order');
        return $statement->fetchAll();
    }

    public function getById(int $id): ?Order
    {
        // get all information about order where id = $id
        $sql = "SELECT id, address, price_total, contact_phone, comments, created_at 
                FROM orders 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Order');
        return $statement->fetch();
    }

    public function create(
        int $user_id,
        string $user_name,
        string $user_email,
        string $address,
        int $price_total,
        string $contact_phone,
        string $comments
    ): bool {
        $sql = "INSERT INTO orders (user_id, user_name, user_email, address, price_total, contact_phone, comments) 
                VALUE (:user_id, :user_name, :user_email, :address, :price_total, :contact_phone, :comments)";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute([
            'user_id' => $user_id,
            'address' => $address,
            'price_total' => $price_total,
            'contact_phone' => $contact_phone,
            'comments' => $comments,
            'user_name' => $user_name,
            'user_email' => $user_email
        ]);
        return true;
    }

    public function update(int $id, int $user_id, string $address, int $price_total,  string $contact_phone, string $comments): bool
    {
        $sql = "UPDATE users 
                SET (   user_id = :user_id
                        address = :address, 
                        price_total = :price_total,
                        contact_phone = :contact_phone
                        comments = :comments ) 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute([   'id' => $id,
                                'user_id' => $user_id,
                                'address' => $address,
                                'price_total' => $price_total,
                                'contact_phone' => $contact_phone,
                                'comments' => $comments
        ]);
        return true;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM orders 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id]);
        return true;
    }

    public function createAllProductsByIdOrder(int $product_id, int $order_id, int $quantity): bool
    {
        // get all products for order where id=$id
        $sql = "INSERT INTO products_order (product_id, order_id, quantity)
                VALUES (:product_id, :order_id, :quantity)";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['product_id' => $product_id, 'order_id' => $order_id, 'quantity' => $quantity]);
        return true;
    }

    public function getAllProductsByIdOrder(int $order_id): array
    {
        // get all products for order where id=$id
        $sql = "SELECT products.id, products.title, products.price, products_order.quantity
                FROM products, products_order
                WHERE products_order.order_id = :order_id and products_order.product_id = products.id;";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['order_id' => $order_id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Product');
        return $statement->fetchAll();
    }

    public function getLastId(): int
    {
        $sql = "SELECT id
                FROM orders 
                ORDER BY id DESC LIMIT 1";
        $statement = $this->getConnect()->query($sql);
        $id = $statement->fetchAll();
        return (int) $id[0]['id'];
    }
}