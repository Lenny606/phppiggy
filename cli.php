<?php

//DNS creation - DATA SOURCE NAME
//driver:key=value format

$driver = 'mysql'; //compatible with mariaDB

//http_build_query function builds url, can be used DNS string to
$config = http_build_query([
    'host' => 'localhost', //key value pair
    'port' => 3306,
    'dbname' => 'phppiggy'
], arg_separator: ';');

$dsn = "{$driver}:{$config}";

echo $dsn;