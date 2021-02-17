<?php

namespace App\Repository;

use App\models\Category;
use App\Tools\Database;
use PDO;

class CategoryRepository
{
    public function getConnect(): PDO
    {
        return Database::getInstance()->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT id, title 
                FROM categories";
        $statement = $this->getConnect()->query($sql);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Category');
        return $statement->fetchAll();
    }

    public function getById(int $id): ?Category
    {
        $sql = "SELECT id, title 
                FROM categories 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Category');
        return $statement->fetch();
    }

    public function create(string $title): bool
    {
        $sql = "INSERT INTO categories title 
                VALUE :title";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['title' => $title]);
        return true;
    }

    public function update(int $id, string $title): bool
    {
        $sql = "UPDATE categories 
                SET title = :title 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['title' => $title, 'id' => $id]);
        return true;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM categories 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id]);
        return true;
    }
}