<?php

namespace App\Repository;

use App\models\Product;
use App\tools\Errors\ProductsErrorException;
use Exception;
use App\Tools\Database;
use PDO;

class ProductRepository
{
    public function getConnect(): PDO
    {
        return Database::getInstance()->getConnection();
    }

    /**
     * @param int $id
     * @return array of Product objects
     * @throws ProductsErrorException
     */
    public function getByCategoryId(int $id): array
    {
        $sql = "SELECT id, category_id, title, price, description, image  
                FROM products 
                WHERE category_id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Product');
        return $statement->fetchAll();
    }

    /**
     * @return array of Product objects
     * @throws ProductsErrorException
     */
    public function getAll(): array
    {
        $sql = "SELECT id, category_id, title, price, description, image  
                FROM products";
        $statement = $this->getConnect()->query($sql);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Product');
        return $statement->fetchAll();
    }

    /**
     * @param int $id
     * @return Product
     * @throws ProductsErrorException
     * @throws Exception
     */
    public function getById(int $id): ?Product
    {
        $sql = "SELECT id, category_id, title, price, description, image  
                FROM products 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Product');
        return $statement->fetch();
    }

    public function create(int $category_id, string $title, int $price, string $description, string $image): bool
    {
        $sql = "INSERT INTO products (category_id, title, price, description, image) 
                VALUES (:category_id, :title, :price, :description, :image)";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute([
                            'category_id' => $category_id,
                            'title' => $title,
                            'price' => $price,
                            'description' => $description,
                            'image' => $image
        ]);
        return true;
    }

    public function update(int $id, int $category_id, string $title, int $price, string $description, string $image): bool
    {
        $sql = "UPDATE products 
                SET (   category_id = :category_id, 
                        title = :title,
                        price = :price, 
                        description = :description,
                        image = :image) 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute([
            'id' => $id,
            'category_id' => $category_id,
            'title' => $title,
            'price' => $price,
            'description' => $description,
            'image' => $image
        ]);
        return true;
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM products 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id]);
        return true;
    }

}