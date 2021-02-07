<?php

namespace App\Repository;

use App\models\Category;
use App\tools\Errors\ProductsErrorException;
use App\tools\Errors\PathException;

class CategoryRepository
{
    public function getConnection()
    {
        $list =  json_decode(file_get_contents('../App/Models/productList.json'));
        if (!empty($list)) {
            return $list;
        } else {
            throw new PathException('There is no data! Try to check if there is the right path to your file');
        }
    }

    public function getCategoryList(): array
    {
        $categoryList = $this->getConnection()[0]->categories;
        $allCategories = [];
        foreach ($categoryList as $item) {
            $categoryObject = new Category();
            $categoryObject->setId((int) $item->id);
            $categoryObject->setName((string) $item->name);
            array_push($allCategories, $categoryObject);
        }
        return $allCategories;
    }

    public function getCategoryById(int $id): ?Category
    {
        if (empty($id)) {
            throw new ProductsErrorException('Must be enter an id for category');
        }
        $categoryList = $this->getConnection()[0]->categories;
        if ($id > count($categoryList)) {
            throw new ProductsErrorException('There is no category by this id=' . "$id");
        }
        $categoryObject = new Category();
        foreach ($categoryList as $item) {
            if ((int) $item->id == $id) {
                $categoryObject->setId((int) $item->id);
                $categoryObject->setName((string) $item->name);
            }
        }
        if (!empty($categoryObject)) {
            return $categoryObject;
        } else {
            throw new ProductsErrorException('There is no category by this id=' . "$id");
        }
    }
}