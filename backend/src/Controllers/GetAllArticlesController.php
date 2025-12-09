<?php

declare(strict_types=1);

namespace Controllers;

use Controllers\ControllerInterface;
use Exception;
use Services\ArticleService;

class GetAllArticlesController implements ControllerInterface
{
    private ArticleService $service;

    public function __construct(ArticleService $service)
    {
        $this->service = $service;
    }

    public function handle()
    {
        $queryParams = $GLOBALS['queryParams'];

        $articlesPerPage = 3;
        $page = isset($queryParams['page']) ? (int)$queryParams['page'] : 1;

        try {
            $articles = $this->service->getArticlesPaginated($page, $articlesPerPage);

            echo json_encode($articles);
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }
}
