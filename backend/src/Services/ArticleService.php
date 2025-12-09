<?php

declare(strict_types=1);

namespace Services;

use Entities\Article;
use Repositories\ArticleRepository;

class ArticleService
{
    protected ArticleRepository $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getArticlesPaginated(int $page, int $perPage): array
    {
        $totalArticles = $this->repository->getTotalArticlesCount();
        $totalPages = ceil($totalArticles / $perPage);
        $offset = ($page - 1) * $perPage;

        $articles = $this->repository->getAllArticles($perPage, $offset);

        return [
            'articles' => $articles,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];
    }

    public function getSingleArticleById(int $id): ?Article
    {
        return $this->repository->getArticleById($id);
    }

    public function postArticle(String $title, String $content, String $url): void
    {
        $this->repository->postArticle($title, $content, $url);
    }
}