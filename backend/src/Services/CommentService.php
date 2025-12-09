<?php

declare(strict_types=1);

namespace Services;

use Repositories\CommentRepository;

class CommentService
{
    protected CommentRepository $repository;

    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getComments(int $id): array
    {
        return $this->repository->getComments($id);
    }

    public function deleteComment(int $commentId): void
    {
        $this->repository->deleteComment($commentId);
    }

    public function postComment(int $article_id, String $name, String $email, String $url, String $comment_text): void
    {
        $this->repository->postComment($article_id, $name, $email, $url, $comment_text);
    }
}