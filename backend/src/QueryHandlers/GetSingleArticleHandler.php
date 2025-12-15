<?php

namespace QueryHandlers;

use DTOs\ArticleDTO;
use Repositories\ArticleRepository;
use Queries\GetSingleArticleQuery;

class GetSingleArticleHandler
{
    protected ArticleRepository $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(GetSingleArticleQuery $query): ArticleDTO
    {
        return $this->repository->getArticleById($query->id);
    }
}