<?php

use App\Repository\CartRepository;
use App\Repository\CategoryRepository;
use App\tools\TemplateMaker;

class CartController
{
    public function add(int $id): bool
    {
        (new CartRepository(''))->addProduct($id);
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }

    public function index()
    {
        $cartRepos = new CartRepository('');
        $products = $cartRepos->getProducts();
        $total = $cartRepos->getTotalPrice($products);
        $render = new TemplateMaker();
        $categoryRepository = new CategoryRepository();
        $render->render('cabinetTemplate', 'cartPage', [$categoryRepository->getAll(),$products, $total]);
    }

    public function delete(int $id): bool
    {
        $cartRepos = new CartRepository('');
        $cartRepos->deleteProduct($id);
        $referrer = $_SERVER['HTTP_REFERER'];
        header("Location: $referrer");
    }
}