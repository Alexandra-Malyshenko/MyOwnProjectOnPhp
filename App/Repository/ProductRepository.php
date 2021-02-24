<?php

namespace App\Repository;

use App\models\Product;
use App\tools\Errors\ProductsErrorException;
use Exception;
use libs\Database;
use PDO;

class ProductRepository
{
    public function getConnect(): PDO
    {
        return Database::getInstance()->getConnection();
    }

    /**
     * @param int $id
     * @param int $start
     * @param int $itemsOnPage
     * @param string $whatOrder
     * @param string $howOrder
     * @return array of Product objects
     */
    public function getByCategoryId(int $id, int $start, int $itemsOnPage, string $whatOrder, string $howOrder): array
    {
        $sql = "SELECT id, category_id, title, price, description, image  
                FROM products 
                WHERE category_id = $id
                ORDER BY $whatOrder $howOrder
                LIMIT $start, $itemsOnPage";
        $statement = $this->getConnect()
            ->prepare($sql);
        $statement->execute([
            'id' => $id,
            'start' => $start,
            'itemsOnPage' => $itemsOnPage,
            'whatOrder' => $whatOrder,
            'howOrder' => $howOrder
        ]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Product');
        return $statement->fetchAll();
    }

    /**
     * @param int $start
     * @param int $itemsOnPage
     * @param string $whatOrder
     * @param string $howOrder
     * @return array of Product objects
     */
    public function getAll(int $start, int $itemsOnPage, string $whatOrder, string $howOrder): array
    {
        $sql = "SELECT id, category_id, title, price, description, image  
                FROM products
                ORDER BY $whatOrder $howOrder    
                LIMIT $start, $itemsOnPage";
        $statement = $this->getConnect()
            ->prepare($sql);
        $statement->execute([
            'start' => $start,
            'itemsOnPage' => $itemsOnPage,
            'whatOrder' => $whatOrder,
            'howOrder' => $howOrder
        ]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Product');

        return $statement->fetchAll();
    }

    /**
     * @param int $id
     * @return Product
     */
    public function getById(int $id): ?Product
    {
        $sql = "SELECT id, category_id, title, price, description, image  
                FROM products 
                WHERE id = :id";
        $statement = $this->getConnect()
            ->prepare($sql);
        $statement->execute(['id' => $id]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Product');
        return $statement->fetch();
    }

    /**
     * @param int $category_id
     * @param string $title
     * @param int $price
     * @param string $description
     * @param string $image
     * @return bool
     */
    public function create(
        int $category_id,
        string $title,
        int $price,
        string $description,
        string $image
    ): bool {
        $sql = "INSERT INTO products (category_id, title, price, description, image) 
                VALUES (:category_id, :title, :price, :description, :image)";
        $statement = $this->getConnect()
            ->prepare($sql);
        $statement->execute([
            'category_id' => $category_id,
            'title' => $title,
            'price' => $price,
            'description' => $description,
            'image' => $image
        ]);
        return true;
    }

    /**
     * @param int $id
     * @param int $category_id
     * @param string $title
     * @param int $price
     * @param string $description
     * @param string $image
     * @return bool
     */
    public function update(
        int $id,
        int $category_id,
        string $title,
        int $price,
        string $description,
        string $image
    ): bool {
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

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM products 
                WHERE id = :id";
        $statement = $this->getConnect()->prepare($sql);
        $statement->execute(['id' => $id]);
        return true;
    }

    /**
     * @return mixed
     */
    public function count()
    {
        $sql = "SELECT COUNT(*) as count FROM products";
        $statement = $this->getConnect()->query($sql);
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $row = $statement->fetch();
        return $row['count'];
    }

    public function search(string $keyword)
    {
        $sql = "SELECT id, category_id, title, price, description, image  
                FROM products
                WHERE title LIKE '%$keyword%'
                or description LIKE '%$keyword%' ";
        $statement = $this->getConnect()
            ->prepare($sql);
        $statement->execute([
            "keyword" => $keyword
        ]);
        $statement->setFetchMode(PDO::FETCH_CLASS, 'App\models\Product');
        return $statement->fetchAll();
    }
}