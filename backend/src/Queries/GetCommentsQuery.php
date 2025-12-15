<?php

namespace Queries;

class GetCommentsQuery
{
    public $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}