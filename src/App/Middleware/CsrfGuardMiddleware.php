<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;

//validate token in form, if not valid form is not processed
class CsrfGuardMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        //tokens only in POST requests
        $requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
        $validMethods = ['POST', 'PATCH', 'DELETE'];

        //if not valid
        if(!in_array($requestMethod, $validMethods)){
            $next();
            return; //rest method should not be executed
        }

        //if tokens do not match , form failed validation and redirect
        if($_SESSION['token'] !== $_POST['token']){
           redirectTo('/');
        }

        //tokens match and destroy - used only once for POST requests
        unset($_SESSION['token']);

        $next();
    }
}