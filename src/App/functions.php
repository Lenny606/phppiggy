<?php

declare(strict_types=1);
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