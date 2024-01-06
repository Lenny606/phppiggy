<?php
declare(strict_types=1);

namespace App\Config;
use App\Middleware\FlashMiddleware;
use App\Middleware\SessionMiddleware;
use App\Middleware\ValidationExceptionMiddleware;
use Framework\App;
use App\Middleware\TemplateDataMiddleware;

//class can be used but function will suffice
//function is called from bootstrap.php
function registerMiddleware(App $app)
{
    //register middleware class
    //router will handle and instantiate middleware
    $app->addMiddleware(TemplateDataMiddleware::class);
    $app->addMiddleware(ValidationExceptionMiddleware::class);
    $app->addMiddleware(FlashMiddleware::class);

    // !!!!session has to be last in register, will be call first in middleware chain
    $app->addMiddleware(SessionMiddleware::class);
}