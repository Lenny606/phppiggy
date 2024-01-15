<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;

class GuestOnlyMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        //if user is logged in, login page should be accessible
        //redirect to homepage
        if(!empty($_SESSION['user'])){
            redirectTo('/');
        }
        $next();
    }
}