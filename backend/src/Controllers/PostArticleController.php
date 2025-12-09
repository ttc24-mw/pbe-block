<?php

declare(strict_types=1);

namespace Controllers;

use Services\ArticleService;
use Controllers\ControllerInterface;
use Exception;

class PostArticleController implements ControllerInterface
{
    private ArticleService $service;

    public function __construct(ArticleService $service)
    {
        $this->service = $service;
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

        try {
            $this->service->postArticle($title, $content, $url);
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }
}
