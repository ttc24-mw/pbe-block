<?php

namespace CommandHandlers;

use Repositories\ArticleRepository;
use Commands\PostArticleCommand;

class PostArticleHandler
{
    protected ArticleRepository $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(PostArticleCommand $command): void
    {
        $this->repository->postArticle($command->title, $command->content, $command->url);
    }
}