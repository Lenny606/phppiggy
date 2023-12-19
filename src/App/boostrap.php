<?php
declare(strict_types = 1);
//file is specific for project, responsible for loading

//DIR sets the absolute path to the dir, used Autoload instead, composet has to be required
//include __DIR__ . '/../Framework/App.php';
require __DIR__ . '/../../vendor/autoload.php';

use Framework\App;
use App\Controllers\HomeController;


$app = new App();

//register paths and controller
$app->get("/home", [HomeController::class, 'home']);
//$app->get("/about");

return $app;