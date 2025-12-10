<?php

namespace Factories;

use Repositories\ArticleRepository;
use Repositories\AuthRepository;
use Repositories\CommentRepository;

class RepositoryFactory
{
    private $mysqli;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function create(string $repoClass): Object
    {
        if($repoClass === ArticleRepository::class ||
           $repoClass === CommentRepository::class ||
           $repoClass === AuthRepository::class) {
            return new $repoClass($this->mysqli);
        }
        throw new \Exception("Unknown repository class: " . $repoClass);
    }
}