<?php

namespace Commands;

class DeleteCommentCommand
{
    public $commentId;

    public function __construct(int $commentId)
    {
        $this->commentId = $commentId;
    }
}