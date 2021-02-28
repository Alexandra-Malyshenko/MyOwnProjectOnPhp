<?php

namespace App\Services;

use App\Repository\CategoryRepository;
use App\tools\Errors\ProductsErrorException;

class CategoryService
{
    private CategoryRepository $categoryRepos;

    public function __construct($categoryRepos)
    {
        $this->categoryRepos = $categoryRepos;
    }

    public function getAll(): array
    {
        return $this->categoryRepos
            ->getAll();
    }

    public function getCategoryById(int $id)
    {
        if (empty($id)) {
            throw new ProductsErrorException('Must be enter an id for category');
        }
        return $this->categoryRepos
            ->getById($id);
    }

    public function createCategory(string $title): bool
    {
        return $this->categoryRepos
            ->create($title);
    }

    public function updateCategory(int $id, string $title): bool
    {
        return $this->categoryRepos
            ->update($id, $title);
    }

    public function deleteCategory(int $id): bool
    {
        return $this->categoryRepos
            ->delete($id);
    }
}