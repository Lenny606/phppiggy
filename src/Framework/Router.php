<?php
declare(strict_types=1);

namespace Framework;

use App\Controllers\HomeController;
use Framework\Contracts\MiddlewareInterface;

class Router
{

    //list of routes, default []
    private array $routes = [];

    //router is responsible for middlewares, MW accessible globally but can be restricted to one route
    private array $middlewares = [];

    /**
     * @param string $method
     * @param string $route
     * @param array $controller
     * @return void
     */
    public function add(string $method, string $route, array $controller): void
    {
        $route = $this->normalizePath($route);

        $regexPath = preg_replace('#{[^/]+}#', '([^/]+)', $route);
        $this->routes[] = [
            'path' => $route,
            'method' => strtoupper($method),
            'controller' => $controller,
            //added option to use some MW only for specific routes
            //adding in addRouteMiddleware method, execution in dispatch(
            'middlewares' => [

            ],
            'regexPath' => $regexPath
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

        //checking for DELETE method which is POST overridden
        $method = strtoupper($_POST['_METHOD'] ?? $method);

        //if path doesnt matches or method is not method skip processing, paramValues are creates dynamically
        foreach ($this->routes as $route) {
            if (!preg_match(
                "#^{$route['regexPath']}$#",
                $path, $paramValues) || $route['method'] !== $method
            ) {
                continue;
            }

            //extract the values to grab the parameters value from the route and combine into new array
            array_shift($paramValues);
            preg_match_all('#{([^/]+)}#', $route['path'], $paramKeys);
            $paramKeys = $paramKeys[1];
            $params = array_combine(
                $paramKeys,
                $paramValues
            );

            //destructuring array [HomeController:class, 'home']
            [$class, $function] = $route['controller'];

            //class has namespace , is possible to create instance
            //added container with reflection pattern
            $controllerInstance = $container ?
                $container->resolve($class) :
                new $class;

            //implements middleware
            $action = fn() => $controllerInstance->{$function}($params);

            //implements specific routes middleware
            //orders matters, global MW have to be last
            //all MW in one array
            $allMiddleware = [...$route['middlewares'], ...$this->middlewares];

            foreach($allMiddleware as $middleware) {

                //in array we have only names, needs to be instatiated (by container)
                /** @var MiddlewareInterface $middlewareInstance */
                $middlewareInstance = $container ?
                    $container->resolve($middleware):
                    new $middleware;

                //overide action with MW + function
                //controller is the last one
                $action = fn() => $middlewareInstance->process($action);

            }
            $action();

            return;
        }
    }

    public function addMiddleware(string $middleware): void
    {
        $this->middlewares[] = $middleware;
    }
    public function addRouteMiddleware(string $middleware): void
    {
        //TODO check again why last route is used
        $lastRouteKey = array_key_last($this->routes);
        $this->routes[$lastRouteKey]['middlewares'][] = $middleware;
    }
}