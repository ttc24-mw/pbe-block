<?php

declare(strict_types=1);

namespace Controllers;

use Controllers\ControllerInterface;
use Exception;
use QueryHandlers\GetAllArticlesHandler;
use Queries\GetAllArticlesQuery;

class GetAllArticlesController implements ControllerInterface
{
    private GetAllArticlesHandler $handler;

    public function __construct(GetAllArticlesHandler $handler)
    {
        $this->handler = $handler;
    }

    public function handle()
    {
        $queryParams = $GLOBALS['queryParams'];

        $articlesPerPage = 3;
        $page = isset($queryParams['page']) ? (int)$queryParams['page'] : 1;

        $query = new GetAllArticlesQuery($page, $articlesPerPage);

        try {
            $articles = $this->handler->handle($query);
            echo json_encode($articles);
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }
}
