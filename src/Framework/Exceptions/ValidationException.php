<?php
declare(strict_types=1);

namespace Framework\Exceptions;

//this type of exception for errors while app is running
//code not for fixing but handling
use RuntimeException;

class ValidationException extends RuntimeException
{
//    override with custom code with constructor
//set default value for 422 code
    public function __construct(
        public array $errors,
        int          $code = 422
    )
    {

        //call parent constructor with named argument
        //throws exception, but it needs to have middleware -> validationExceptionMiddleware
        parent::__construct(code: $code);
    }
}