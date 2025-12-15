<?php

namespace CommandHandlers;

use Repositories\AuthRepository;

class LogoutUserHandler
{
    protected AuthRepository $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(): void
    {
        $this->repository->logout();
    }
}