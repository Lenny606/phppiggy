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

        if ($containerDefinitionsPath) {
            $containerDefinitions = include $containerDefinitionsPath;
            $this->container->addDefinitions($containerDefinitions);
        }
    }

    public function run(): void
    {
        //extract path from url
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        $this->router->dispatch($path, $method, $this->container);
    }

    public function get(string $route, array $controller): self //for chaining in Routes.php
    {
        $this->router->add("GET", $route, $controller);
        return $this;
    }

    public function post(string $route, array $controller): self
    {
        $this->router->add('POST', $route, $controller);
        return $this;
    }

    public function delete(string $route, array $controller): self
    {
        $this->router->add('DELETE', $route, $controller);
        return $this;
    }

    public function addMiddleware(string $middleware): self
    {
        $this->router->addMiddleware($middleware);

        return $this;
    }

    public function addRouteMiddleware(string $middleware): self
    {
        $this->router->addRouteMiddleware($middleware);

        return $this;
    }

    public function addErrorHandler(array $controller): self
    {
        $this->router->setErrorHandler($controller);

        return $this;
    }
}