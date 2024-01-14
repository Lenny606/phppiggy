<?php
declare(strict_types=1);

namespace App\Config;
use App\Middleware\CsrfGuardMiddleware;
use App\Middleware\CsrfTokenMiddleware;
use App\Middleware\FlashMiddleware;
use App\Middleware\SessionMiddleware;
use App\Middleware\ValidationExceptionMiddleware;
use Framework\App;
use App\Middleware\TemplateDataMiddleware;

//class can be used but function will suffice
//function is called from bootstrap.php
function registerMiddleware(App $app)
{
    //register middleware class, order matters (tokens, session f.e.)
    //router will handle and instantiate middleware

    //this token middleware should be first
    $app->addMiddleware(CsrfGuardMiddleware::class);
    $app->addMiddleware(CsrfTokenMiddleware::class);


    $app->addMiddleware(TemplateDataMiddleware::class);
    $app->addMiddleware(ValidationExceptionMiddleware::class);
    $app->addMiddleware(FlashMiddleware::class);

    // !!!!session has to be last in register, will be call first in middleware chain
    $app->addMiddleware(SessionMiddleware::class);
}