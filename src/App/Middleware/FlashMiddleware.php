<?php

declare(strict_types=1);

namespace App\Middleware;


use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

class FlashMiddleware implements MiddlewareInterface
{

    public function __construct(
        private TemplateEngine $view
    )
    {

    }

    public function process(callable $next)
    {
        //adds variables globally
        //if is null, set []
        $this->view->addGlobal('errors', $_SESSION['errors'] ?? []);

        //send form values to template
        $this->view->addGlobal('oldFormData', $_SESSION['oldFormData'] ?? []);

        //destroys variables from template
        unset($_SESSION['errors']);
        unset($_SESSION['oldFormData']);

        $next();


    }
}