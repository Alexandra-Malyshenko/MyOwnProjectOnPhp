<?php

namespace App\Repository;

use libs\Database;
use App\models\WishList;
use PDO;

class WishListRepository
{
    public function getConnect(): PDO
    {
        return Database::getInstance()->getConnection();
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $sql = "SELECT id, product_id, user_id  
                FROM wish_list";
        $statement = $this->getConnect()->query($sql);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\WishList');
        return $statement->fetchAll();
    }

    /**
     * @param int $id
     * @return array
     */
    public function getByUserId(int $id)
    {
        $sql = "SELECT id, product_id, user_id  
                FROM wish_list 
                WHERE user_id = :user_id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['user_id' => $id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\WishList');
        return $statement->fetchAll();
    }

    /**
     * @param int $id
     * @return WishList|null
     */
    public function getById(int $id): ?WishList
    {
        $sql = "SELECT id, product_id, user_id  
                FROM wish_list 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\WishList');
        return $statement->fetch();
    }

    /**
     * @param int $product_id
     * @param int $user_id
     * @return bool
     */
    public function create(int $product_id, int $user_id): bool
    {
        $sql = "INSERT INTO wish_list (product_id, user_id) 
                VALUES (:product_id, :user_id)";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute([
            'product_id' => $product_id,
            'user_id' => $user_id
        ]);
        return true;
    }

    /**
     * @param int $id
     * @param int $product_id
     * @param int $user_id
     * @return bool
     */
    public function update(int $id, int $product_id, int $user_id): bool
    {
        $sql = "UPDATE wish_list 
                SET (   product_id = :product_id, 
                        user_id = :user_id) 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute([
            'id' => $id,
            'product_id' => $product_id,
            'user_id' => $user_id
        ]);
        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM wish_list 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id]);
        return true;
    }
}