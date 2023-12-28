<?php
declare(strict_types=1);

namespace Framework;

//can be used for inspect classes
use ReflectionClass;

//job of the container is to store instructions for creating instances
//isntruction refers to definitions -> outsourced in separate file
class Container
{

    private array $definitions = [];

    public function addDefinitions(array $newDefinitions)
    {
        //merge arrays with array_merge or spread operator
//        $this->definitions = array_merge($this->definitions, $newDefinitions);
        $this->definitions = [...$this->definitions, ...$newDefinitions];

    }

    public function resolve(string $className){

        $reflection = new ReflectionClass($className);

    }
}