<?php
namespace System;

use System\Http\Request;
use System\Http\Route;

class Router
{

    protected $routes;

    function __construct()
    {
        $this->routes = [
            'GET' => [],
            'POST' => [],
            'PUT' => [],
            'DELETE' => [],
            'OPTIONS' => [],
            'HEAD' => [],
            'PATCH' => []
        ];
    }


    function map(Request $request)
    {

        $router = $this;
        $_route = null;

        include(__DIR__ . '/../app/Routes.php');

        try {
            $_route = $this->matchRequest($request);
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }

        return $_route;

    }

    function matchRequest(Request $request)
    {
        $method = $request->getMethod();
        if (array_key_exists($method, $this->routes)) {
            foreach ($this->routes[$method] as $route) {
                if ($route->match($request)) return $route;
            }
        }
        return false;
    }

    function get($uri = null, $controller = null)
    {
        if (!$uri || !$controller) return false;
        $route = new Route($uri, explode('::', $controller));
        $this->routes['GET'][$uri] = $route;
        return $route;
    }

    function post($uri = null, $controller = null)
    {
        if (!$uri || !$controller) return false;
        $route = new Route($uri, explode('::', $controller));
        $this->routes['POST'][$uri] = $route;
        return $route;
    }

    function put($uri = null, $controller = null)
    {
        if (!$uri || !$controller) return false;
        $route = new Route($uri, explode('::', $controller));
        $this->routes['PUT'][$uri] = $route;
        return $route;
    }

    function delete($uri = null, $controller = null)
    {
        if (!$uri || !$controller) return false;
        $route = new Route($uri, explode('::', $controller));
        $this->routes['DELETE'][$uri] = $route;
        return $route;
    }

    function options($uri = null, $controller = null)
    {
        if (!$uri || !$controller) return false;
        $route = new Route($uri, explode('::', $controller));
        $this->routes['OPTIONS'][$uri] = $route;
        return $route;
    }

    function patch($uri = null, $controller = null)
    {
        if (!$uri || !$controller) return false;
        $route = new Route($uri, explode('::', $controller));
        $this->routes['PATCH'][$uri] = $route;
        return $route;
    }

    function head($uri = null, $controller = null)
    {
        if (!$uri || !$controller) return false;
        $route = new Route($uri, explode('::', $controller));
        $this->routes['HEAD'][$uri] = $route;
        return $route;
    }


}
