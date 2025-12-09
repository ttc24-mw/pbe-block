<?php

declare(strict_types=1);

namespace Services;

use Repositories\AuthRepository;

class AuthService
{
    protected AuthRepository $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function login(String $username, String $password): void
    {
        $this->repository->login($username, $password);
    }

    public function logout(): void
    {
        $this->repository->logout();
    }
}