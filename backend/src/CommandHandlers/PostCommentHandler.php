<?php

namespace CommandHandlers;

use Repositories\CommentRepository;
use Commands\PostCommentCommand;

class PostCommentHandler
{
    protected CommentRepository $repository;

    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(PostCommentCommand $command): void
    {
        $this->repository->postComment($command->article_id, $command->name, $command->email, $command->url, $command->comment_text);
    }
}