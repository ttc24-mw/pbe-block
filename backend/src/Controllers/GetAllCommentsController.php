<?php

declare(strict_types=1);

namespace Controllers;

use Queries\GetCommentsQuery;
use QueryHandlers\GetCommentsHandler;
use Controllers\ControllerInterface;
use Exception;

class GetAllCommentsController implements ControllerInterface
{
    private GetCommentsHandler $handler;

    public function __construct(GetCommentsHandler $handler)
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

        $query = new GetCommentsQuery($id);

        try {
            $comments = $this->handler->handle($query);
            echo json_encode($comments);
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }
}
