<?php

declare(strict_types=1);

namespace Controllers;

use Services\CommentService;
use Controllers\ControllerInterface;
use Exception;

class PostCommentController implements ControllerInterface
{
    private CommentService $service;

    public function __construct(CommentService $service)
    {
        $this->service = $service;
    }

    public function handle()
    {
        $body = $GLOBALS['body'];

        if (!isset($body['articleId']) || !isset($body['name']) || !isset($body['email'])  || !isset($body['url']) || !isset($body['commentText'])) {
            return;
        }

        $article_id = $body['articleId'];
        $name = $body['name'];
        $email = $body['email'];
        $url = $body['url'];
        $comment_text = $body['commentText'];

        try {
            $this->service->postComment($article_id, $name, $email, $url, $comment_text);
        } catch (Exception $e) {
            http_response_code(500);
            echo 'error';
        }
    }
}
