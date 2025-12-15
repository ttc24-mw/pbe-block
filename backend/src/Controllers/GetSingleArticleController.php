<?php

declare(strict_types=1);

namespace Controllers;

use Queries\GetSingleArticleQuery;
use QueryHandlers\GetSingleArticleHandler;
use Controllers\ControllerInterface;
use Exception;

require_once 'ControllerInterface.php';

class GetSingleArticleController implements ControllerInterface
{
    private GetSingleArticleHandler $handler;

    public function __construct(GetSingleArticleHandler $handler)
    {
        $this->handler = $handler;
    }

    public function handle()
    {
        $queryParams = $GLOBALS['queryParams'];

        if (!isset($queryParams['id'])) {
            return;
        }

        $id = (int)$queryParams['id'];

        $query = new GetSingleArticleQuery($id);

        try {
            $article = $this->handler->handle($query);
            echo json_encode($article);
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }
}
