<?php
declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;

class AuthenticationRequiredMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        //MW runs before controller so we need to check if user is logged in with session
        //if not, redirect to login page
        if(empty($_SESSION['user'])){
            redirectTo('/login');
        }
        $next();
    }
}