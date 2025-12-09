<?php

namespace Entities;

class Article
{
    public int $id;
    public string $title;
    public string $content;
    public string $createdAt;
    public string $pictureUrl;
    public int $commentsCount;
    public string $authorName;

    public function __construct(
        int $id,
        string $title,
        string $content,
        string $createdAt,
        string $pictureUrl,
        int $commentsCount,
        string $authorName
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->pictureUrl = $pictureUrl;
        $this->commentsCount = $commentsCount;
        $this->authorName = $authorName;
    }
}