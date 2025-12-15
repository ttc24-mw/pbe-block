<?php

declare(strict_types=1);

namespace Controllers;

use CommandHandlers\LoginUserHandler;
use Commands\LoginUserCommand;
use Controllers\ControllerInterface;
use Exception;

class LoginController implements ControllerInterface
{
    private LoginUserHandler $handler;

    public function __construct(LoginUserHandler $handler)
    {
        $this->handler = $handler;
    }

    public function handle()
    {
        $body = $GLOBALS['body'];

        if (!isset($body['username']) || !isset($body['password'])) {
            return;
        }

        $username = $body['username'];
        $password = $body['password'];

        $command = new LoginUserCommand($username, $password);

        try {
            $this->handler->handle($command);
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }
}
