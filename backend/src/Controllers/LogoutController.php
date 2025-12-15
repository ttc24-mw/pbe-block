<?php

declare(strict_types=1);

namespace Controllers;

use CommandHandlers\LogoutUserHandler;
use Controllers\ControllerInterface;
use Exception;

class LogoutController implements ControllerInterface
{
    private LogoutUserHandler $handler;

    public function __construct(LogoutUserHandler $handler)
    {
        $this->handler = $handler;
    }

    public function handle()
    {
        try {
            $this->handler->handle();
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }
}
