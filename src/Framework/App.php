<?php

declare(strict_types=1);

namespace Framework;

use App\Controllers\HomeController;

class App
{

    private Router $router;
    private Container $container;

    public function __construct(string $containerDefinitionsPath = null)
    {
        $this->router = new Router();
        $this->container = new Container();

        if($containerDefinitionsPath){
            $containerDefinitions = include $containerDefinitionsPath;
            $this->container->addDefinitions($containerDefinitions);
        }
    }

    public function run(): void
    {
        //extract path from url
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        $this->router->dispatch($path, $method);
    }

    public function get(string $route, array $controller): void
    {
        $this->router->add("GET", $route, $controller);
    }
}