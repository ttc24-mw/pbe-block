<?php

namespace Commands;

class PostArticleCommand
{
    public string $title;
    public string $content;
    public string $url;

    public function __construct(String $title, String $content, String $url)
    {
        $this->title = $title;
        $this->content = $content;
        $this->url = $url;
    }
}
