<?php

declare(strict_types=1);

namespace Controllers;

use Services\CommentService;
use Controllers\ControllerInterface;
use Exception;

class DeleteCommentController implements ControllerInterface
{
    private CommentService $service;

    public function __construct(CommentService $service)
    {
        $this->service = $service;
    }

    public function handle()
    {
        $queryParams = $GLOBALS['queryParams'];

        if (!isset($queryParams['commentId'])) {
            return;
        }

        $commentId = (int)$queryParams['commentId'];

        try {
            $this->service->deleteComment($commentId);
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }
}
