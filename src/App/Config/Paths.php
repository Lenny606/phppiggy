<?php
declare(strict_types=1);

namespace App\Config;

class Paths
{

    /**
     * config path to the directory
     * set up into homecontroller
     */
    public const VIEW = __DIR__ . '/../views';
    //points to the root
    public const SOURCE = __DIR__ . '/../../';
//    points to the env file
    public const ROOT = __DIR__ . '/../../../';

    public function __construct()
    {
    }
}