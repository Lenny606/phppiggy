<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

/**
 * responsible for rendering homepage
 * here is the good place to have instace of template engine if the is no container
 *
 */
class HomeController
{
    private TemplateEngine $view;

    public function __construct()
    {
//        path is configured in Paths class
        $this->view = new TemplateEngine(Paths::VIEW);
    }

    /**
     * @return void
     */
    public function home()
    {
        //renders return value of the render method
        echo $this->view->render("index.php", [
            'title' => 'Home'
        ]);
    }
}