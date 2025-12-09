<?php

declare(strict_types=1);

namespace Repositories;

class AuthRepository
{
    private $mysqli;

    private $query;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function login(String $username, String $password): void
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM users WHERE name = ? AND password_hash = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $session_user_id = $row['id'];
            $session_username = $row['name'];

            $stmt = $this->mysqli->prepare("INSERT INTO session (user_id, username) VALUES (?, ?)");
            $stmt->bind_param("is", $session_user_id, $session_username);
            $stmt->execute();
            $result = $stmt->get_result();

            echo json_encode([
                "status" => "success",
                "user_id" => $session_user_id,
                "user_name" => $session_username
            ]);
        } else {
            echo json_encode([
                "status" => "failed",
                "msg" => "Login fehlgeschlagen"
            ]);
        }
        $stmt->close();
    }

    public function logout(): void
    {
        session_start();

        $stmt = $this->mysqli->prepare("DELETE FROM session");
        $result = $stmt->execute();

        session_destroy();

        if ($result) {
            echo json_encode([
                "status" => "success",
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Logout failed"
            ]);
        }
        $stmt->close();
        exit;
    }
}
