<?php
declare(strict_types = 1);
//file is specific for project, responsible for loading

//DIR sets the absolute path to the dir, used Autoload instead, composet has to be required
//include __DIR__ . '/../Framework/App.php';
require __DIR__ . '/../../vendor/autoload.php';

use Framework\App;
use App\Controllers\HomeController;
use App\Controllers\AboutController;

//import function from file
use function App\Config\registerRoutes;

$app = new App();
//use routes function to register routes - new way
//setup function path in composer autoload manually , doesnt work same as with classes
//then run cmd composer dump-autoload
registerRoutes($app);


//register paths and controller - old way directly in bootstrap
//$app->get("/home", [HomeController::class, 'home']);
//$app->get("/about", [AboutController::class, 'about']);


return $app;