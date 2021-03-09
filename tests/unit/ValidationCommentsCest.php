<?php

use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use App\Services\CommentService;
use App\Services\ProductService;

class ValidationCommentsCest
{
    private CommentService $commentsService;
    private ProductService $prodService;

    public function _before(UnitTester $I, libs\Database $database)
    {
        $this->db = new $database($_ENV['DB_HOST'], $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        $this->prodService = new ProductService(new ProductRepository($this->db));
        $this->commentsService = new CommentService(new CommentRepository($this->db), $this->prodService);
    }

    public function tryToTestGetCommentsByUserId(UnitTester $I)
    {
        $result = $this->commentsService->getCommentsByUserId(1, 0, 24);
        $I->assertIsArray($result);
        $I->assertCount(6, $result);
    }

    public function tryToTestGetCommentById(UnitTester $I)
    {
        $result = $this->commentsService->getCommentById(4);
        $I->assertObjectHasAttribute('text', $result);
        $I->assertInstanceOf(\App\models\Comment::class, $result);
    }

    public function tryToTestGetCommentByProductId(UnitTester $I)
    {
        $result = $this->commentsService->getCommentsByProductId(5);
        $I->assertContainsOnlyInstancesOf(\App\models\Comment::class, $result);
        $I->seeNumRecords(1, 'comments', ['id' => 3]);
    }

    public function tryToTestCountComments(UnitTester $I)
    {
        $result = $this->commentsService->count(1);
        $I->seeNumRecords($result, 'comments');
    }
}
