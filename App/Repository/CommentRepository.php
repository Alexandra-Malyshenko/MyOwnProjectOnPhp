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

    /**
     * @return array
     */
    public function getAll(): array
    {
        $sql = "SELECT id, product_id, user_id, text, created_at  
                FROM comments";
        $statement = $this->getConnect()->query($sql);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Comment');
        return $statement->fetchAll();
    }

    /**
     * @param int $user_id
     * @param int $start
     * @param int $itemsOnPage
     * @return array
     */
    public function getByUserId(int $user_id, int $start, int $itemsOnPage): array
    {
        $sql = "SELECT id, product_id, user_id, text, created_at  
                FROM comments 
                WHERE user_id = :user_id
                LIMIT $start, $itemsOnPage";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['user_id' => $user_id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Comment');
        return $statement->fetchAll();
    }

    /**
     * @param int $product_id
     * @return array
     */
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

    /**
     * @param int $id
     * @return Comment|null
     */
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

    /**
     * @param int $product_id
     * @param int $user_id
     * @param string $text
     * @return bool
     */
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

    /**
     * @param int $id
     * @param int $product_id
     * @param int $user_id
     * @param $text
     * @return bool
     */
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

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM comments 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id]);
        return true;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function count(int $id)
    {
        $sql = "SELECT COUNT(*) as count FROM comments WHERE user_id = $id";
        $statement = $this->getConnect()->query($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $row = $statement->fetch();
        return $row['count'];
    }
}