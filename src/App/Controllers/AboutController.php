<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Config\Paths;
use Framework\TemplateEngine;

class AboutController {

    public function __construct(private TemplateEngine $view) {
        $this->view = new TemplateEngine(Paths::VIEW);
    }

    public function about() {
        $this->view->render('about.php',
        [
            'about' => "ABOUT PAGe"
        ]);
    }
}