<?php

namespace App\Repository;

use App\Tools\Database;
use App\models\WishList;
use PDO;

class WishListRepository
{
    public function getConnect(): PDO
    {
        return Database::getInstance()->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT id, product_id, user_id  
                FROM wish_list";
        $statement = $this->getConnect()->query($sql);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\WishList');
        return $statement->fetchAll();
    }

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

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM wish_list 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id]);
        return true;
    }
}