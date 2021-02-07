<?php

namespace App\Repository;

use App\models\Product;
use App\tools\Errors\ProductsErrorException;
use Exception;

class ProductRepository
{
    public function getConnection()
    {
        $list =  json_decode(file_get_contents('../App/Models/productList.json'));
        if (!empty($list)) {
            return $list;
        } else {
            throw new ProductsErrorException('There is no data! Try check if there is right path to file');
        }
    }

    /**
     * @param int $id
     * @return array of Product objects
     * @throws ProductsErrorException
     */
    public function getProductsByCategoryId(int $id): array
    {
        $productsList = $this->getConnection()[1]->products;
        $productsListByCategory = [];
        if (empty($id)) {
            throw new ProductsErrorException('There is no category by this id=' . "$id");
        }
        foreach ($productsList as $product) {
            if ((int)$product->category_id == $id) {
                $productObject = new Product();
                $productObject->setId((int)$product->id);
                $productObject->setCategoryId((int)$product->category_id);
                $productObject->setName((string)$product->name);
                $productObject->setPrice((int)$product->price);
                $productObject->setDescription((string)$product->description);
                $productObject->setImage((string)$product->image);
                array_push($productsListByCategory, $productObject);
            }
        }
        return $productsListByCategory;
    }

    /**
     * @return array of Product objects
     * @throws ProductsErrorException
     */
    public function getListOfProducts(): array
    {
        $productsList = $this->getConnection()[1]->products;
        $allProducts = [];
        foreach ($productsList as $product) {
            $productObject = new Product();
            $productObject->setId((int) $product->id);
            $productObject->setCategoryId((int) $product->category_id);
            $productObject->setName((string) $product->name);
            $productObject->setPrice((int) $product->price);
            $productObject->setDescription((string) $product->description);
            $productObject->setImage((string) $product->image);
            array_push($allProducts, $productObject);
        }
        return $allProducts;
    }

    /**
     * @param int $id
     * @return Product
     * @throws ProductsErrorException
     * @throws Exception
     */
    public function getProductById(int $id): ?Product
    {
        $productsList = $this->getConnection()[1]->products;
        if ($id > count($productsList)) {
            throw new ProductsErrorException('There is no product by this id=' . "$id");
        }
        $productObjectById = new Product();
        foreach ($productsList as $product) {
            if ((int) $product->id == $id) {
                $productObjectById->setId((int) $product->id);
                $productObjectById->setCategoryId((int) $product->category_id);
                $productObjectById->setName((string) $product->name);
                $productObjectById->setPrice((int) $product->price);
                $productObjectById->setDescription((string) $product->description);
                $productObjectById->setImage((string) $product->image);
            }
        }
        if (!empty($productObjectById)) {
            return $productObjectById;
        } else {
            throw new ProductsErrorException('There is no product by this id=' . "$id");
        }
    }
}