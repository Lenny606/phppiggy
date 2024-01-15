<?php

include __DIR__.'/../src/App/functions.php';
//responsible to initialize app, not for loading classes - boostrap will do this

//include bootstrap and store in variable
$app = include __DIR__.'/../src/App/boostrap.php';


$app->run();