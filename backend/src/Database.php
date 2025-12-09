<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

class Database
{
    // $host = 'mysql_db'; // Docker service name for MySQL
    // $port = 3306; // Default MySQL port
    // private string $host = 'localhost'; // for mamp
    // private string $user = 'root';
    // private string $pass = 'root';
    // private string $db = 'blog_app';
    public $mysqli;

    public function __construct(
        private string $host,
        private string $user,
        private string $pass,
        private string $db
    ) {
    }

    public function getConnection()
    {
        return $this->mysqli = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->db
        );

        if ($this->mysqli->connect_error) {
            die("Connection failed: ". $this->mysqli->connect_error);
        };
    }
}
