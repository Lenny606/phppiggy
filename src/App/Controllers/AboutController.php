<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Config\Paths;
use Framework\TemplateEngine;

class AboutController
{

    public function __construct(
        private TemplateEngine $view
    )
    {
        //creating instance is not needed anymore, because DI in constructor
        //$this->view = new TemplateEngine(Paths::VIEW);
    }

    public function about()
    {
        echo $this->view->render('about.php');
    }
}