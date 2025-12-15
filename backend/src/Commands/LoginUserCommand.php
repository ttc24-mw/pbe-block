<?php

namespace Commands;

class LoginUserCommand
{
    public string $username;
    public string $password;

    public function __construct(String $username, String $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
}
