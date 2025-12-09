<?php

declare(strict_types=1);

namespace Repositories;

use Entities\Article;

class ArticleRepository
{
    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getTotalArticlesCount(): int
    {
        $result = mysqli_query($this->mysqli, "SELECT COUNT(*) AS total FROM articles");
        if ($result) {
            $countRow = $result->fetch_assoc();
            return (int)$countRow['total'];
        }
        return 0;
    }

    public function getAllArticles(int $articlesPerPage, int $offset): array
    {
        $query = "SELECT a.id, a.title, a.content, a.created_at, a.picture_url, (SELECT COUNT(*) FROM comments c WHERE c.article_id = a.id) AS comments_count, u.name AS author_name
            FROM articles a
            JOIN users u ON a.author_id = u.id
            ORDER BY a.created_at DESC
            LIMIT ? OFFSET ?";

        $stmt = $this->mysqli->prepare($query);
        if (!$stmt) {
            return [];
        }
        $stmt->bind_param('ii', $articlesPerPage, $offset);
        $stmt->execute();

        $result = $stmt->get_result();
        $articles = [];
        while ($row = $result->fetch_assoc()) {
            $articles[] = new Article(
                (int)$row['id'],
                $row['title'],
                $row['content'],
                $row['created_at'],
                $row['picture_url'],
                (int)$row['comments_count'],
                $row['author_name'],
            );
        }

        $stmt->close();
        return $articles;
    }


    public function getArticleById(int $id): ?Article
    {
        $query = "SELECT a.id, a.title, a.content, a.created_at, a.picture_url, a.comments_count, u.name AS author_name
                FROM articles a
                JOIN users u ON a.author_id = u.id
                WHERE a.id = ?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();


        $article = new Article(
            (int)$row['id'],
            $row['title'],
            $row['content'],
            $row['created_at'],
            $row['picture_url'],
            (int)$row['comments_count'],
            $row['author_name'],
        );

        $stmt->close();
        return $article ?: null;
    }

    public function postArticle(String $title, String $content, String $url): void
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM session");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $session_user_id = $row['user_id'];
        }

        $stmt = $this->mysqli->prepare("INSERT INTO articles (title, content, author_id, picture_url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $title, $content, $session_user_id, $url);
        $result = $stmt->execute();

        if ($result) {
            echo json_encode([
                "status" => "success",
                "title" => $title,
                "content" => $content,
                "url" => $url,
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database Query Failed"]);
        }
        $stmt->close();
    }
}
