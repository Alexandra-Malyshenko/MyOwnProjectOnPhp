<?php

namespace App\Services;

use App\Services\ProductService;

class SearchService
{
    public function search(string $searchText)
    {
        $keywords = preg_split("/[\s,]+/", $searchText);
        $products = [];
        foreach ($keywords as $keyword) {
            $products = (new ProductService())->searchProducts($keyword);
        }
        return $products;
    }
}