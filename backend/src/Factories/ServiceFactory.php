<?php

namespace Factories;

use Services\ArticleService;
use Services\AuthService;
use Services\CommentService;

class ServiceFactory implements FactoryInterface
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function create(string $serviceClass, ?string $dependencyClass = null): Object
    {
        if($serviceClass === ArticleService::class ||
           $serviceClass === CommentService::class ||
           $serviceClass === AuthService::class) {
            return new $serviceClass($this->container->get($dependencyClass));
        }
        throw new \Exception("Unknown service class: " . $serviceClass);
    }
}