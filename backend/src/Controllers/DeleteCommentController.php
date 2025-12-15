<?php

declare(strict_types=1);

namespace Controllers;

use CommandHandlers\DeleteCommentHandler;
use Commands\DeleteCommentCommand;
use Controllers\ControllerInterface;
use Exception;

class DeleteCommentController implements ControllerInterface
{
    private DeleteCommentHandler $handler;

    public function __construct(DeleteCommentHandler $handler)
    {
        $this->handler = $handler;
    }

    public function handle()
    {
        $queryParams = $GLOBALS['queryParams'];

        if (!isset($queryParams['commentId'])) {
            return;
        }

        $commentId = (int)$queryParams['commentId'];

        $command = new DeleteCommentCommand($commentId);

        try {
            $this->handler->handle($command);
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }
}
