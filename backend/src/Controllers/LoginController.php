<?php

declare(strict_types=1);

namespace Controllers;

use Services\AuthService;
use Controllers\ControllerInterface;
use Exception;

class LoginController implements ControllerInterface
{
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function handle()
    {
        $body = $GLOBALS['body'];

        if (!isset($body['username']) || !isset($body['password'])) {
            return;
        }

        $username = $body['username'];
        $password = $body['password'];

        try {
            $this->service->login($username, $password);
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }
}
