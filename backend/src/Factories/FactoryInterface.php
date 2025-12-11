<?php

namespace Factories;

interface FactoryInterface
{
    public function create(string$class, ?string $dependencyClass = null): Object;
}
