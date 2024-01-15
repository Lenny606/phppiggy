<?php
declare(strict_types=1);

namespace Framework;

//can be used for inspect classes
use Framework\Exceptions\ContainerException;
use ReflectionClass;
use ReflectionNamedType;

//job of the container is to store instructions for creating instances
//instruction refers to definitions -> outsourced in separate file
class Container
{

    private array $definitions = [];
    private array $resolved = [];

    public function addDefinitions(array $newDefinitions)
    {
        //merge arrays with array_merge or spread operator
//        $this->definitions = array_merge($this->definitions, $newDefinitions);
        $this->definitions = [...$this->definitions, ...$newDefinitions];

    }

    public function resolve(string $className)
    {

        $reflection = new ReflectionClass($className);

        //validate class if it can be instantiated
        //if not throw exception (custom exception)
        if (!$reflection->isInstantiable()) {
            //1st argument is message
            throw new ContainerException('You cannot instantiate class' . $className);
        }

        //reflection class has method what retrievs constructor
        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new $className;
        }

        //return parameters from constructor if there are some parameters or []
        $params = $constructor->getParameters();

        //validation if there are params in array
        if (count($params) === 0) {
            return new $className;
        }

        //validation of parameters
        //dependencies stores instances required by controller
        $dependencies = [];
        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();

            if (!$type) {
                throw new ContainerException("Failed to resolve {$className} because {$name} doesnt have a type hint");
            }

            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new ContainerException("Failed to resolve {$className} because invalid param name");
            }

            $dependencies[] = $this->get($type->getName());
        }

        //new instances from array are returned
        return $reflection->newInstanceArgs($dependencies);
    }

    /**
     * this method instantiates and returns an instance of dependency from container
     * function should be called from resolve method
     * @param $id string classname
     *
     */
    public function get(string $id)
    {
        if(!array_key_exists($id, $this->definitions)) {
            throw new ContainerException("Class {$id} doesnt exists in container");
        }

        //singleton pattern, using for MW
        if(array_key_exists($id, $this->resolved)){
            //use resolved[] for singleton pattern
            //if exists return that instance, not creating a new one
            return $this->resolved[$id];
        }

        //if id exits create instance from factory
        //items in array are factory functions which should be called
        $factory = $this->definitions[$id];
        $dependency = $factory($this); //this == container instance passed to factory function

        //use resolved[] for singleton pattern
        $this->resolved[$id] =  $dependency;

        //return dependency in the end
        return $dependency;

    }
}