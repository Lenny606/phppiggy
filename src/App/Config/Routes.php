<?php
//LOGIC for registering in separate file (from Bootstrap)
declare(strict_types=1);

namespace App\Config;


use Framework\App;
use App\Controllers\{AuthController, HomeController, AboutController};

function registerRoutes(App $app)
{
    $app->get("/", [HomeController::class, 'home']);
    $app->get("/about", [AboutController::class, 'about']);
    $app->get("/register", [AuthController::class, 'registerView']);
    $app->post("/register", [AuthController::class, 'register']);
}