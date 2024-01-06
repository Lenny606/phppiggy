<?php

declare(strict_types=1);

//global functions
function dd(mixed $var): void
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    die();
}

/**
 * Function prevents XSS attack
 * @param mixed $value
 * @return string
 */
function escape(mixed $value): string
{
    return htmlspecialchars((string)$value);
}

//get request, needs header, status code
//exit stops the script to prevent errors
function redirectTo(string $path){
    header("Location: {$path}");
    http_response_code(302);
    exit;
}