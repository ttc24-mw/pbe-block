<?php

use CommandHandlers\PostCommentHandler;
use PHPUnit\Framework\TestCase;
use Controllers\PostCommentController;

require_once __DIR__ . '/../../vendor/autoload.php';

class PostCommentControllerTest extends TestCase
{
    public function testHandleCallsPostCommentWithValidInput()
    {
        $mockPostCommentHandler = $this->createMock(PostCommentHandler::class);
        $mockPostCommentHandler->expects($this->once())
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

        $controller = new PostCommentController($mockPostCommentHandler);

        $controller->handle();
    }

    public function testHandleDoesNotCallPostCommentWhenBodyIncomplete()
    {
        $mockPostCommentHandler = $this->createMock(PostCommentHandler::class);

        $GLOBALS['body'] = [
            'articleId' => 123,
            'name' => 'John Doe',
            // 'email' is missing
            // 'commentText' is missing
        ];

        $controller = new PostCommentController($mockPostCommentHandler);
        $controller->handle();

        $mockPostCommentHandler->expects($this->never())->method('postComment');
    }
}