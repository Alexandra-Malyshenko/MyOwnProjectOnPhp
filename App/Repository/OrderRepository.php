<?php

namespace App\Repository;

use App\models\Order;
use App\models\Product;
use libs\Database;
use PDO;

class OrderRepository
{
    private PDO $getConnect;

    public function __construct(Database $database)
    {
        $this->getConnect = $database->getConnection();
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $sql = "SELECT id, user_id, address, price_total, contact_phone, comments, created_at 
                FROM orders";
        $statement = $this->getConnect->query($sql);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Order');
        return $statement->fetchAll();
    }

    /**
     * @param int $user_id
     * @param $start
     * @param $itemsOnPage
     * @return array
     */
    public function getAllByUserId(int $user_id, $start, $itemsOnPage): array
    {
        $sql = "SELECT id, address, price_total, contact_phone, comments, created_at 
                FROM orders 
                WHERE user_id = :user_id
                LIMIT $start, $itemsOnPage";
        $statement = $this->getConnect->prepare($sql);
        $statement->execute(['user_id' => $user_id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Order');
        return $statement->fetchAll();
    }

    /**
     * @param int $id
     * @return Order|null
     */
    public function getById(int $id): ?Order
    {
        $sql = "SELECT id, address, price_total, contact_phone, comments, created_at 
                FROM orders 
                WHERE id = :id";
        $statement = $this->getConnect->prepare($sql);
        $statement->execute(['id' => $id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Order');
        return $statement->fetch();
    }

    /**
     * @param int $user_id
     * @param string $user_name
     * @param string $user_email
     * @param string $address
     * @param int $price_total
     * @param string $contact_phone
     * @param string $comments
     * @return bool
     */
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
        $statement = $this->getConnect->prepare($sql);
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

    /**
     * @param int $id
     * @param int $user_id
     * @param string $address
     * @param int $price_total
     * @param string $contact_phone
     * @param string $comments
     * @return bool
     */
    public function update(
        int $id,
        int $user_id,
        string $address,
        int $price_total,
        string $contact_phone,
        string $comments
    ): bool {
        $sql = "UPDATE users 
                SET (   user_id = :user_id
                        address = :address, 
                        price_total = :price_total,
                        contact_phone = :contact_phone
                        comments = :comments ) 
                WHERE id = :id";
        $statement = $this->getConnect->prepare($sql);
        $statement->execute([
            'id' => $id,
            'user_id' => $user_id,
            'address' => $address,
            'price_total' => $price_total,
            'contact_phone' => $contact_phone,
            'comments' => $comments
        ]);
        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM orders 
                WHERE id = :id";
        $statement = $this->getConnect->prepare($sql);
        $statement->execute(['id' => $id]);
        return true;
    }

    /**
     * @param int $product_id
     * @param int $order_id
     * @param int $quantity
     * @return bool
     */
    public function createAllProductsByIdOrder(int $product_id, int $order_id, int $quantity): bool
    {
        $sql = "INSERT INTO products_order (product_id, order_id, quantity)
                VALUES (:product_id, :order_id, :quantity)";
        $statement = $this->getConnect->prepare($sql);
        $statement->execute(['product_id' => $product_id, 'order_id' => $order_id, 'quantity' => $quantity]);
        return true;
    }

    /**
     * @param int $order_id
     * @return array
     */
    public function getAllProductsByIdOrder(int $order_id): array
    {
        $sql = "SELECT products.id, products.title, products.price, products_order.quantity
                FROM products, products_order
                WHERE products_order.order_id = :order_id and products_order.product_id = products.id;";
        $statement = $this->getConnect->prepare($sql);
        $statement->execute(['order_id' => $order_id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Product');
        return $statement->fetchAll();
    }

    /**
     * @return int
     */
    public function getLastId(): int
    {
        $sql = "SELECT id
                FROM orders 
                ORDER BY id DESC LIMIT 1";
        $statement = $this->getConnect->query($sql);
        $id = $statement->fetchAll();
        return (int) $id[0]['id'];
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function count(int $id)
    {
        $sql = "SELECT COUNT(*) as count FROM orders WHERE user_id = $id";
        $statement = $this->getConnect->query($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $row = $statement->fetch();
        return $row['count'];
    }
}