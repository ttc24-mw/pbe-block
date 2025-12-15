<?php

declare(strict_types=1);

namespace Controllers;

use CommandHandlers\PostCommentHandler;
use Commands\PostCommentCommand;
use Controllers\ControllerInterface;
use Exception;

class PostCommentController implements ControllerInterface
{
    private PostCommentHandler $handler;

    public function __construct(PostCommentHandler $handler)
    {
        $this->handler = $handler;
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

        $command = new PostCommentCommand($article_id, $name, $email, $url, $comment_text);

        try {
            $this->handler->handle($command);
        } catch (Exception $e) {
            http_response_code(500);
            echo 'error';
        }
    }
}
