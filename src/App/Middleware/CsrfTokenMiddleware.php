<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

class CsrfTokenMiddleware implements MiddlewareInterface
{
    //exposing tokens for templates
    public function __construct(private TemplateEngine $view)
    {
    }

    public function process(callable $next)
    {
        //returns binary data, has to be converted for browser compatibility
        //if token exists use him, otherwise generate new token
        $_SESSION['token'] =   $_SESSION['token'] ??  bin2hex(random_bytes(32));

        //add as global variable into template
        $this->view->addGlobal('csrfToken', $_SESSION['token']);
        $next();
    }
}