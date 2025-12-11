<?php

use PHPUnit\Framework\TestCase;
use Controllers\PostCommentController;
use Services\CommentService;

require_once __DIR__ . '/../../vendor/autoload.php';

class PostCommentControllerTest extends TestCase
{
    public function testHandleCallsPostCommentWithValidInput()
    {
        $mockService = $this->createMock(CommentService::class);
        $mockService->expects($this->once())
            ->method('postComment')
            ->with(
                $this->equalTo(123),
                $this->equalTo('John Doe'),
                $this->equalTo('john@example.com'),
                $this->equalTo('http://example.com'),
                $this->equalTo('This is a comment')
            );

        $GLOBALS['body'] = [
            'articleId' => 123,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'url' => 'http://example.com',
            'commentText' => 'This is a comment'
        ];

        $controller = new PostCommentController($mockService);

        $controller->handle();
    }

    public function testHandleDoesNotCallPostCommentWhenBodyIncomplete()
    {
        $mockService = $this->createMock(CommentService::class);

        $GLOBALS['body'] = [
            'articleId' => 123,
            'name' => 'John Doe',
            // 'email' is missing
            // 'commentText' is missing
        ];

        $controller = new PostCommentController($mockService);
        $controller->handle();

        $mockService->expects($this->never())->method('postComment');
    }
}