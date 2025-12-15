<?php

namespace Queries;

class GetAllArticlesQuery
{
    public $page;
    public $perPage;

    public function __construct(int $page, int $perPage)
    {
        $this->page = $page;
        $this->perPage = $perPage;
    }
}