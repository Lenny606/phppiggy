<?php
declare(strict_types=1);

namespace Framework;

//job of the container is to store instructions for creating instances
//isntruction refers to definitions -> outsourced in separate file
class Container
{

    private array $definitions = [];

    public function addDefinitions(array $definitions) {

    }
}