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
    public const STORAGE_UPLOADS = __DIR__ . '/../../../storage/uploads';

    public function __construct()
    {
    }
}