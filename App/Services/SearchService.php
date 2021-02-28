<?php

namespace App\Services;

use App\Services\ProductService;

class SearchService
{
    private $prodService;

    public function __construct($prodService)
    {
        $this->prodService = $prodService;
    }

    public function search(string $searchText)
    {
        $keywords = preg_split("/[\s,]+/", $searchText);
        $products = [];
        foreach ($keywords as $keyword) {
            $products = $this->prodService->searchProducts($keyword);
        }
        return $products;
    }
}