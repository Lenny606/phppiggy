<?php
declare(strict_types=1);

namespace Framework\Exceptions;

//this type of exception for errors while app is running
//code not for fixing but handling
use RuntimeException;

class ValidationException extends RuntimeException
{

}