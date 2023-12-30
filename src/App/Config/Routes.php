<?php
//LOGIC for registering in separate file (from Bootstrap)
declare(strict_types=1);

namespace App\Config;


use Framework\App;
use App\Controllers\{HomeController, AboutController};

function registerRoutes(App $app)
{
    $app->get("/", [HomeController::class, 'home']);
    $app->get("/about", [AboutController::class, 'about']);
}