<?php

use App\Repository\ProductRepository;
use App\Resources\ProductResource;
use App\Services\ProductService;

class ValidationProductsCest
{
    private ProductRepository $productRepository;
    private ProductResource $productResourse;

    public function _before(UnitTester $I, libs\Database $database)
    {
        $this->db = new $database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $this->productRepository = new App\Repository\ProductRepository($this->db);
        $this->productResourse = new ProductResource();
    }

    public function tryToTestGetAllProducts(UnitTester $I)
    {
        $products = $this->productRepository->getAll(0, 24, 'title', 'ASC');
        $I->assertObjectHasAttribute('title', $products[0]);
        $I->assertIsArray($products);
    }

    public function tryToTestProductById(UnitTester $I)
    {
        $product = $this->productRepository->getById(3);
        $I->assertObjectHasAttribute('title', $product);
        $I->assertObjectHasAttribute('price', $product);
    }

    public function tryToTestProductByCategoryId(UnitTester $I)
    {
        $products = $this->productRepository->getByCategoryId(3, 0, 24, 'title', 'ASC');
        $I->assertEquals($products[0]->getCategoryId(), 3);
    }

    public function tryToTestGetJsonOfProducts(UnitTester $I)
    {
        $productService = new ProductService($this->productRepository);
        $products = json_encode(
            $productService->getProductsJSON(0, 24, ['title', 'ASC']),
            JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK
        );
        $I->assertJson($products);
    }
}
