<?php
declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

class TemplateDataMiddleware implements MiddlewareInterface
{
    public function __construct(
        private TemplateEngine $view
    ){
            }
 public function process(callable $next)
 {
     $this->view->addGlobal('title', "TRACKING APP" );
     $this->view->addGlobal('appTitle', "PHP Piggy" );

     //runs next MW what is passed as parameter
     $next();
 }
}