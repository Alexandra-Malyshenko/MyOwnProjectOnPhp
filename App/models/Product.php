<?php


namespace App\models;


class Product
{
    public function getConnection()
    {
        return json_decode(file_get_contents('../App/models/productList.json'));
    }

    public function getProductsByCategoryId(int $id)
    {
        $table = $this->getConnection();
        $products = [];
        $item = [];

        foreach ($table[1]->products as $product)
        {

            if ((int) $product->category_id == $id) {
                $item["id"] = $product->id;
                $item["name"] = $product->name;
                $item["price"] = $product->price;
                $item["description"] = $product->description;
                $item["image"] = $product->image;
            }
            if (!empty($item)) {
                array_push($products, $item);
                $item = [];
            }
        }
        return $products;
    }

    public function getListOfProducts()
    {
        $table = $this->getConnection();
        $products = [];
        $item = [];

        foreach ($table[1]->products as $product)
        {
            $item["id"] = $product->id;
            $item["name"] = $product->name;
            $item["price"] = $product->price;
            $item["description"] = $product->description;
            $item["image"] = $product->image;

            array_push($products, $item);
            $item = [];
        }
        return $products;
    }

    public function getProductById(int $id)
    {
        $table = $this->getConnection();
        $item = [];

        foreach ($table[1]->products as $product)
        {

            if ((int) $product->id == $id) {
                $item["id"] = $product->id;
                $item["name"] = $product->name;
                $item["price"] = $product->price;
                $item["description"] = $product->description;
                $item["image"] = $product->image;
            }

        }
        return $item;
    }


}