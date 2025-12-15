<?php

declare(strict_types=1);

namespace DTOs;

class CommentDTO
{
    public int $id;
    public int $article_id;
    public string $name;
    public string $comment_text;
    public string $created_at;

    public function __construct(
        int $id,
        int $article_id,
        string $name,
        string $comment_text,
        string $created_at,
    ) {
        $this->id = $id;
        $this->article_id = $article_id;
        $this->name = $name;
        $this->comment_text = $comment_text;
        $this->created_at = $created_at;
    }
}
