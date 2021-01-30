<?php
namespace App\models;

class Category
{

    public function getConnection()
    {
        return json_decode(file_get_contents('../App/models/productList.json'));
    }

    public function getCategoryList()
    {
        $table = $this->getConnection();
        $categories = [];

        foreach ($table[0]->categories as $category) {
            array_push($categories, $category->name);
        }
    }

    public function getCategoryById(int $id)
    {
        $table = $this->getConnection();

        foreach ($table[0]->categories as $category) {
            if ((int) $category->id == $id) {
                return $category;
            }

        }
    }
}