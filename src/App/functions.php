<?php

declare(strict_types=1);
function dd(mixed $var): void
{
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    die();
}