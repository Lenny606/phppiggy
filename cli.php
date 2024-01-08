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
$username = 'root';
$password = '';

try{
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    die("Could not connect to dtb"); //stops the script
}
echo "connected to database";