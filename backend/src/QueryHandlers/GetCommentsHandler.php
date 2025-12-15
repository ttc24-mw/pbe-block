<?php

namespace QueryHandlers;

use Repositories\CommentRepository;
use Queries\GetCommentsQuery;

class GetCommentsHandler
{
    protected CommentRepository $repository;

    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(GetCommentsQuery $query): array
    {
        return $this->repository->getComments($query->id);
    }
}