<?php

namespace QueryHandlers;

use Repositories\ArticleRepository;
use Queries\GetAllArticlesQuery;

class GetAllArticlesHandler
{
    protected ArticleRepository $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(GetAllArticlesQuery $query): array
    {
        $perPage = $query->perPage;
        $page = $query->page;

        $totalArticles = $this->repository->getTotalArticlesCount();
        $totalPages = ceil($totalArticles / $query->perPage);
        $offset = ($page - 1) * $perPage;

        $articles = $this->repository->getAllArticles($perPage, $offset);

        return [
            'articles' => $articles,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];
    }
}