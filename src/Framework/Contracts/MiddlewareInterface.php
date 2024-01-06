<?php
declare(strict_types=1);

namespace Framework\Contracts;

//contracts === interfaces
interface MiddlewareInterface
{
    //purpose of process method is to process request
    //process method is called before controller handles request
    //MW runs one after another -> next parameter is a function what initializes next middleware
    public function process(callable $next);
}