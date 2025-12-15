<?php

namespace Queries;

class GetSingleArticleQuery
{
    public $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}