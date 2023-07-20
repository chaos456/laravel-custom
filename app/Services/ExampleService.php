<?php

namespace App\Services;

class ExampleService extends BaseService
{
    protected string $name;

    protected int $age;

    public function __construct(string $name, int $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    public function getName()
    {
        return $this->name;
    }
}
