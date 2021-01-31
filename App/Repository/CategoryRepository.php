<?php

namespace App\Repository;

use App\models\Category;
use App\tools\Errors\ProductsErrorException;
use App\tools\logger\Logger;

class CategoryRepository
{
    private $logger;

    public function __construct()
    {
        $this->logger = new Logger("category");
    }

    public function getConnection()
    {
        $list =  json_decode(file_get_contents('../App/Models/productList.json'));
        if (!empty($list)){
            return $list;
        } else {
            $this->logger->warning('There is no data! Try check if there is right path to file');
            throw new ProductsErrorException('There is no data! Try check if there is right path to file');
        }
    }

    public function getCategoryList(): array
    {
        $categoryList = $this->getConnection()[0]->categories;
        $allCategories = [];
        $categoryObject = new Category();

        foreach ($categoryList as $item) {
            $categoryObject->setId((int) $item->id);
            $categoryObject->setName((string) $item->name);
            array_push($allCategories, $categoryObject);
        }

        return $allCategories;
    }

    public function getCategoryById(int $id): ?Category
    {
        if (empty($id)) {
            $this->logger->warning('There is no category by this id=', ["id" => $id]);
            throw new ProductsErrorException($id, 'There id no category by this id=');
        }

        $categoryList = $this->getConnection()[0]->categories;
        $categoryObject = new Category();

        foreach ($categoryList as $item) {

            if ((int) $item->id == $id) {
                $categoryObject->setId((int) $item->id);
                $categoryObject->setName((string) $item->name);
                return $categoryObject;
            }
        }
    }

}