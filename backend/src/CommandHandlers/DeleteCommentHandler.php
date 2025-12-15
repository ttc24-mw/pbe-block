<?php

namespace CommandHandlers;

use Repositories\CommentRepository;
use Commands\DeleteCommentCommand;

class DeleteCommentHandler
{
    protected CommentRepository $repository;

    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(DeleteCommentCommand $command): void
    {
        $this->repository->deleteComment($command->commentId);
    }
}