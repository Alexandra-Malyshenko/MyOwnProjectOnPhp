<?php

namespace App\Services;

use App\Repository\CommentRepository;

class CommentService
{
    /**
     * @var CommentRepository
     */
    private CommentRepository $commentRepos;

    public function __construct()
    {
        $this->commentRepos = new CommentRepository();
    }

    public function getCommentsByUserId(int $user_id, int $start, int $itemsOnPage): array
    {
        return $this->commentRepos->getByUserId($user_id, $start, $itemsOnPage);
    }

    public function getCommentsByProductId(int $product_id): array
    {
        return $this->commentRepos->getByProductId($product_id);
    }

    public function getCommentById(int $id)
    {
        return $this->commentRepos->getById($id);
    }

    public function createComment(int $product_id, int $user_id, string $text): bool
    {
        return $this->commentRepos->create($product_id, $user_id, $text);
    }

    public function updateComment(int $id, int $product_id, int $user_id, string $text): bool
    {
        return $this->commentRepos->update($id, $product_id, $user_id, $text);
    }

    public function delete(int $id): bool
    {
        return $this->commentRepos->delete($id);
    }

    public function getProductsInComment(array $comments)
    {
        $products = [];
        foreach ($comments as $comment) {
            $product = (new ProductService())->getProductById($comment->getProductId());
            array_push($products, $product);
        }
        return $products;
    }

    public function count(int $id): int
    {
        return (int) $this->commentRepos->count($id);
    }
}