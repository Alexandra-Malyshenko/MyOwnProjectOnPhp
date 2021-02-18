<?php

namespace App\Repository;

use App\models\Comment;
use libs\Database;
use PDO;

class CommentRepository
{
    public function getConnect(): PDO
    {
        return Database::getInstance()->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT id, product_id, user_id, text, created_at  
                FROM comments";
        $statement = $this->getConnect()->query($sql);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Comment');
        return $statement->fetchAll();
    }

    public function getByUserId(int $user_id): array
    {
        $sql = "SELECT id, product_id, user_id, text, created_at  
                FROM comments 
                WHERE user_id = :user_id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['user_id' => $user_id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Comment');
        return $statement->fetchAll();
    }

    public function getByProductId(int $product_id): array
    {
        $sql = "SELECT id, product_id, user_id, text, created_at  
                FROM comments 
                WHERE product_id = :product_id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['product_id' => $product_id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Comment');
        return $statement->fetchAll();
    }

    public function getById(int $id): ?Comment
    {
        $sql = "SELECT id, product_id, user_id, text, created_at  
                FROM comments 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Comment');
        return $statement->fetch();
    }

    public function create(int $product_id, int $user_id, string $text): bool
    {
        $sql = "INSERT INTO comments (text, user_id, product_id) 
                VALUES (:text, :user_id, :product_id)";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute([
            'product_id' => $product_id,
            'user_id' => $user_id,
            'text' => $text
        ]);
        return true;
    }

    public function update(int $id, int $product_id, int $user_id, $text): bool
    {
        $sql = "UPDATE comments 
                SET (   product_id = :product_id, 
                        user_id = :user_id,
                        text = :text) 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute([
            'id' => $id,
            'product_id' => $product_id,
            'user_id' => $user_id,
            'text' => $text
        ]);
        return true;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM comments 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id]);
        return true;
    }
}