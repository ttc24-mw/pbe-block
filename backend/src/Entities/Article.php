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
}