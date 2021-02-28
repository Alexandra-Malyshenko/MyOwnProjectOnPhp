<?php

use App\Repository\ProductRepository;
use App\Resources\ProductResource;
use App\Services\ProductService;

class ValidationProductsCest
{
    private ProductService $productService;
    private PDO $db;
    private ProductResource $productResourse;

    public function _before(UnitTester $I)
    {
        $host = 'localhost';
        $db_name = "proj_test";
        $userDB = 'proj_user';
        $passwordDB = 'Password1!';
        $this->db = new PDO("mysql:host={$host};dbname={$db_name}", $userDB, $passwordDB);
        $this->productService = new ProductService(new ProductRepository($this->db));
        $this->productResourse = new ProductResource();
    }

    public function tryToTestGetAllProducts(UnitTester $I)
    {
        $products = $this->productService->getAll(0, 24, ['title', 'ASC']);
        $I->assertObjectHasAttribute('title', $products[0]);
        $I->assertIsArray($products);
    }

    public function tryToTestProductById(UnitTester $I)
    {
        $product = $this->productService->getProductById(3);
        $I->assertObjectHasAttribute('title', $product);
        $I->assertObjectHasAttribute('price', $product);
    }

    public function tryToTestProductByCategoryId(UnitTester $I)
    {
        $products = $this->productService->getByCategoryId(3, 0, 24, ['title', 'ASC']);
        $I->assertEquals($products[0]->getCategoryId(), 3);
    }

    public function tryToTestGetJsonOfProducts(UnitTester $I)
    {
        $products = json_encode(
            $this->productService->getProductsJSON(0, 24, ['title', 'ASC']),
            JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK
        );
        $I->assertJson($products);
    }
}
