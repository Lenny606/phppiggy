<?php
declare(strict_types=1);

namespace Framework;

use App\Controllers\HomeController;

class Router
{

    //list of routes, default []
    private array $routes = [];

    /**
     * @param string $method
     * @param string $route
     * @param array $controller
     * @return void
     */
    public function add(string $method, string $route, array $controller): void
    {
        $route = $this->normalizePath($route);
        $this->routes[] = [
            'path' => $route,
            'method' => strtoupper($method),
            'controller' => $controller
        ];
    }

    /**
     * creates a new normalized route
     * @param string $path
     * @return string
     */
    public function normalizePath(string $path): string
    {
        //to be sure, that there are no double slashes, remove them
        $path = trim($path, '/');
        //set slash
        $path = "/${path}/";
        //use regex pattern
        $path = preg_replace('#[/]{2,}#', '/', $path);

        return $path;
    }

    /**
     * Dispatching page content from server
     * @param string $path
     * @param string $method
     * @return void
     */
    public function dispatch(string $path, string $method, Container $container = null): void
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($method);

        //if path doesnt matches or method is not method skip processing
        foreach ($this->routes as $route) {
            if (!preg_match("#^{$route['path']}$#", $path) || $route['method'] !== $method) {
                continue;
            }
            //destructuring array [HomeController:class, 'home']
            [$class, $function] = $route['controller'];

            //class has namespace , is possible to create instance
            //added container with reflection pattern
            $controllerInstance = $container ?
                $container->resolve($class) :
                new $class;

            $controllerInstance->$function();

        }
    }

}