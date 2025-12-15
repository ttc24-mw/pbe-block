<?php

declare(strict_types=1);

namespace Entities;

class Comment
{
    public int $id;
    public int $article_id;
    public string $name;
    public string $comment_text;
    public string $created_at;
}