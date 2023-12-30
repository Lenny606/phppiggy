<?php
declare(strict_types=1);

namespace App\Config;
use Framework\App;
use App\Middleware\TemplateDataMiddleware;

//class can be used but function will suffice
//function is called from bootstrap.php
function registerMiddleware(App $app)
{
    //register middleware class
    //router will handle and instantiate middleware
    $app->addMiddleware(TemplateDataMiddleware::class);
}