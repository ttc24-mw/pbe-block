<?php

declare(strict_types=1);

namespace Controllers;

use Services\CommentService;
use Controllers\ControllerInterface;
use Exception;

class GetAllCommentsController implements ControllerInterface
{
    private CommentService $service;

    public function __construct(CommentService $service)
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
            $comments = $this->service->getComments($id);
            echo json_encode($comments);
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }
}
