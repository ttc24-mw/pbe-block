<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');


class Database
{
    public $mysqli;

    public function __construct(
        private string $host,
        private string $user,
        private string $pass,
        private string $db,
        private int $port,
    ) {
    }

    public function getConnection()
    {
        return $this->mysqli = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->db,
            $this->port,
        );

        if ($this->mysqli->connect_error) {
            die("Connection failed: ". $this->mysqli->connect_error);
        };
    }
}
