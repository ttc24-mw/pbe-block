<?php

declare(strict_types=1);

namespace Repositories;

use DTOs\CommentDTO;

class CommentRepository
{
    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getComments(int $id): array
    {
        $query = "SELECT c.id, c.article_id, c.name, c.comment_text, c.created_at
          FROM comments c
          WHERE c.article_id = ?
          ORDER BY c.created_at DESC";

        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = new CommentDTO(
                            (int)$row['id'],
                            (int)$row['article_id'],
                            $row['name'],
                            $row['comment_text'],
                            $row['created_at'],
                        );
        }

        $stmt->close();
        return $comments;
    }

    public function deleteComment(int $commentId): void
    {
        $stmt = $this->mysqli->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->bind_param("i", $commentId);
        $stmt->execute();
        http_response_code(200);
        $stmt->close();
    }

    public function postComment(int $article_id, String $name, String $email, String $url, String $comment_text): void
    {
        $stmt = $this->mysqli->prepare("INSERT INTO comments (article_id, name, email, url, comment_text) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $article_id, $name, $email, $url, $comment_text);
        $result = $stmt->execute();

        if ($result) {
            echo json_encode([
                "status" => "success",
            ]);
        } else {
            echo json_encode(['message' => 'Failed to post comment']);
        }
        $stmt->close();
    }
}
