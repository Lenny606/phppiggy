<?php
declare(strict_types=1);

use Framework\TemplateEngine;
use App\Config\Paths;


//return from file
//factory functions as methods in assoc array
//keys have to be unique
return [
    TemplateEngine::class => fn() => new TemplateEngine(Paths::VIEW)
];