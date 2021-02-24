<?php

namespace App\Resources;

class ProductResource
{
    public function toArrayCollection(array $products): array
    {
        $productsJSON = [];
        foreach ($products as $product) {
            array_push($productsJSON, $this->toArrayOne($product));
        }
        return $productsJSON;
    }

    public function toArrayOne($product): array
    {
        return [
            "id" => $product->getId(),
            "category_id" => $product->getCategoryId(),
            "title" => $product->getTitle(),
            "price" => $product->getPrice(),
            "description" => $product->getDescription(),
            "image" => $product->getImage()
        ];
    }
}