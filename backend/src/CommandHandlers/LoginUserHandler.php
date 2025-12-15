<?php

namespace CommandHandlers;

use Repositories\AuthRepository;
use Commands\LoginUserCommand;

class LoginUserHandler
{
    protected AuthRepository $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(LoginUserCommand $command): void
    {
        $this->repository->login($command->username, $command->password);
    }
}