<?php


namespace App\models;
use App\tools\logger\Logger;
use App\tools\Errors\ProductsErrorException;


class Product
{
    private $logger;

    public function __construct()
    {
        $this->logger = new Logger("products");
    }

    public function getConnection()
    {
        $list =  json_decode(file_get_contents('../App/models/productList.json'));
        if (!empty($list)){
            return $list;
        } else {
            $this->logger->warning('There is no data! Try check if there is right path to file');
            throw new ProductsErrorException('There is no data! Try check if there is right path to file');
        }
    }

    public function getProductsByCategoryId(int $id)
    {
        $productsList = $this->getConnection()[1]->products;
        $productsListByCategory = [];
        $item = [];

        foreach ($productsList as $product)
        {

            if ((int) $product->category_id == $id) {
                $item["id"] = $product->id;
                $item["name"] = $product->name;
                $item["price"] = $product->price;
                $item["description"] = $product->description;
                $item["image"] = $product->image;
            } else {
                $this->logger->warning('There is no category by this id=', ["id" => $id]);
                throw new ProductsErrorException($id, 'There id no category by this id=');
            }
            if (!empty($item)) {
                array_push($productsListByCategory, $item);
                $item = [];
            }
        }
        return $productsListByCategory;
    }

    public function getListOfProducts()
    {
        $productsList = $this->getConnection()[1]->products;
        $allProducts = [];
        $item = [];

        foreach ($productsList as $product)
        {
            $item["id"] = $product->id;
            $item["name"] = $product->name;
            $item["price"] = $product->price;
            $item["description"] = $product->description;
            $item["image"] = $product->image;

            array_push($allProducts, $item);
            $item = [];
        }
        return $allProducts;
    }

    public function getProductById(int $id)
    {
        $productsList = $this->getConnection()[1]->products;
        $productById = [];

        foreach ($productsList as $product)
        {

            if ((int) $product->id == $id) {
                $productById["id"] = $product->id;
                $productById["name"] = $product->name;
                $productById["price"] = $product->price;
                $productById["description"] = $product->description;
                $productById["image"] = $product->image;
            } else {
                $this->logger->warning('There is no product by this id=', ["id" => $id]);
                throw new ProductsErrorException($id, 'There id no product by number id=');
            }

        }
        return $productById;
    }


}