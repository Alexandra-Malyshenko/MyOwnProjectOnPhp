<?php
namespace App\models;
use App\tools\Errors\ProductsErrorException;
use App\tools\logger\Logger;

class Category
{

    private $logger;

    public function __construct()
    {
        $this->logger = new Logger("category");
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

    public function getCategoryList()
    {
        $categoryList = $this->getConnection()[0]->categories;
        $allCategories = [];

        foreach ($categoryList as $category) {
            array_push($allCategories, $category->name);
        }

        return $allCategories;
    }

    public function getCategoryById(int $id)
    {
        $categoryList = $this->getConnection()[0]->categories;

        foreach ($categoryList as $category) {
            if ((int) $category->id == $id) {
                return $category;
            } else {
                $this->logger->warning('There is no category by this id=', ["id" => $id]);
                throw new ProductsErrorException($id, 'There id no category by this id=');
            }

        }
    }
}