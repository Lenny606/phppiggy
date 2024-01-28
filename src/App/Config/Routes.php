<?php
//LOGIC for registering in separate file (from Bootstrap)
declare(strict_types=1);

namespace App\Config;


use App\Middleware\AuthenticationRequiredMiddleware;
use App\Middleware\GuestOnlyMiddleware;
use Framework\App;
use App\Controllers\{AuthController, HomeController, AboutController, ReceiptController, TransactionController};

function registerRoutes(App $app)
{
    /********
     * GET  *
     ********/
    $app->get("/", [HomeController::class, 'home'])->addRouteMiddleware(AuthenticationRequiredMiddleware::class);
    $app->get("/about", [AboutController::class, 'about']);
    $app->get("/register", [AuthController::class, 'registerView'])->addRouteMiddleware(GuestOnlyMiddleware::class);
    $app->get("/login", [AuthController::class, 'loginView'])->addRouteMiddleware(GuestOnlyMiddleware::class);
    $app->get("/logout", [AuthController::class, 'logoutView'])->addRouteMiddleware(AuthenticationRequiredMiddleware::class);;
    $app->get("/transaction", [TransactionController::class, 'createView'])->addRouteMiddleware(AuthenticationRequiredMiddleware::class);;
    $app->get("/transaction", [TransactionController::class, 'createView'])->addRouteMiddleware(AuthenticationRequiredMiddleware::class);;
    $app->get("/transaction/{transactionId}", [TransactionController::class, 'editView'])->addRouteMiddleware(AuthenticationRequiredMiddleware::class);;
    $app->get("/transaction/{transactionId}/receipt/", [ReceiptController::class, 'uploadView'])->addRouteMiddleware(AuthenticationRequiredMiddleware::class);;

    /********
     * POST  *
     ********/
    $app->post("/register", [AuthController::class, 'register'])->addRouteMiddleware(GuestOnlyMiddleware::class);
    $app->post("/login", [AuthController::class, 'login'])->addRouteMiddleware(GuestOnlyMiddleware::class);
    $app->post("/transaction", [TransactionController::class, 'create'])->addRouteMiddleware(AuthenticationRequiredMiddleware::class);
    $app->post("/transaction/{transactionId}", [TransactionController::class, 'edit'])->addRouteMiddleware(AuthenticationRequiredMiddleware::class);;
    $app->post("/transaction/{transactionId}/receipt/", [ReceiptController::class, 'upload'])->addRouteMiddleware(AuthenticationRequiredMiddleware::class);;

    /********
     * DELETE  *
     ********/
    $app->delete("/transaction/{transactionId}", [TransactionController::class, 'delete'])->addRouteMiddleware(AuthenticationRequiredMiddleware::class);;
}