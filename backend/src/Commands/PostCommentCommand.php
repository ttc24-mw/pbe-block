<?php

namespace Commands;

class PostCommentCommand
{
    public int $article_id;
    public String $name;
    public String $email;
    public String $url;
    public String $comment_text;

    public function __construct(int $article_id, String $name, String $email, String $url, String $comment_text)
    {
        $this->article_id = $article_id;
        $this->name = $name;
        $this->email = $email;
        $this->url = $url;
        $this->comment_text = $comment_text;
    }
}
