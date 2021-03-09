<?php

use App\Repository\ProductRepository;
use App\Resources\ProductResource;
use App\Services\ProductService;
use DI\Container;

class ValidationProductsCest
{
    private ProductRepository $productRepository;
    private PDO $db;
    private ProductResource $productResourse;

    public function _before(UnitTester $I)
    {
        $container = new Container();
        $db = $container->get('');
        $this->productRepository =
        $this->productResourse = new ProductResource();
    }

    public function tryToTestGetAllProducts(UnitTester $I)
    {
        $products = $this->productRepository->getAll(0, 24, 'title', 'ASC');
        $I->assertObjectHasAttribute('title', $products[0]);
        $I->assertIsArray($products);
    }

//    public function tryToTestProductById(UnitTester $I)
//    {
//        $product = $this->productService->getProductById(3);
//        $I->assertObjectHasAttribute('title', $product);
//        $I->assertObjectHasAttribute('price', $product);
//    }

//    public function tryToTestProductByCategoryId(UnitTester $I)
//    {
//        $products = $this->productService->getByCategoryId(3, 0, 24, ['title', 'ASC']);
//        $I->assertEquals($products[0]->getCategoryId(), 3);
//    }

//    public function tryToTestGetJsonOfProducts(UnitTester $I)
//    {
//        $products = json_encode(
//            $this->productService->getProductsJSON(0, 24, ['title', 'ASC']),
//            JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK
//        );
//        $I->assertJson($products);
//    }
}
