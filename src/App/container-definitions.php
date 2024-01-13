<?php
declare(strict_types=1);

use App\Services\ValidatorService;
use Framework\Database;
use Framework\TemplateEngine;
use App\Config\Paths;


//return from file
//factory functions as methods in assoc array
//keys in array are most important and have to be unique
return [
    TemplateEngine::class => fn() => new TemplateEngine(Paths::VIEW),
    ValidatorService::class => fn() => new ValidatorService(),
    Database::class => fn() => new Database(
        $_ENV['DB_DRIVER'],
        [
            $_ENV['DB_HOST'],
            $_ENV['DB_USER'],
            $_ENV['DB_NAME']
        ],
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD']
    )
];