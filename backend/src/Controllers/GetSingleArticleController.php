<?php

declare(strict_types=1);

namespace Controllers;

use Services\ArticleService;
use Controllers\ControllerInterface;
use Exception;

require_once 'ControllerInterface.php';

class GetSingleArticleController implements ControllerInterface
{
    private ArticleService $service;

    public function __construct(ArticleService $service)
    {
        $this->service = $service;
    }

    public function handle()
    {
        $queryParams = $GLOBALS['queryParams'];

        if (!isset($queryParams['id'])) {
            return;
        }

        $id = (int)$queryParams['id'];

        try {
            $article = $this->service->getSingleArticleById($id);
            echo json_encode($article);
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }
}
