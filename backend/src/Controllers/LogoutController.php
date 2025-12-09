<?php

declare(strict_types=1);

namespace Controllers;

use Services\AuthService;
use Controllers\ControllerInterface;
use Exception;

class LogoutController implements ControllerInterface
{
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function handle()
    {
        try {
            $this->service->logout();
        } catch (Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }
}
