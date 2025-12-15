<?php

declare(strict_types=1);

namespace Controllers;

use CommandHandlers\PostArticleHandler;
use Commands\PostArticleCommand;
use Controllers\ControllerInterface;
use Exception;

class PostArticleController implements ControllerInterface
{
    private PostArticleHandler $handler;

    public function __construct(PostArticleHandler $handler)
    {
        $this->handler = $handler;
    }

    public function handle()
    {
        $body = $GLOBALS['body'];

        if (!isset($body['title']) || !isset($body['text']) || !isset($body['url'])) {
            return;
        }

        $title = $body['title'];
        $content = $body['text'];
        $url = $body['url'];

        $command = new PostArticleCommand($title, $content, $url);

        try {
            $this->handler->handle($command);
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }
}
