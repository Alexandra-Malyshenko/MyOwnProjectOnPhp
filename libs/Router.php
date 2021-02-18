<?php

namespace libs;

use App\tools\Errors\PathException;

class Router
{
    /**
     * table routes
     * @var array
     */
    protected static array $routes = [];

    /**
     * current route
     * @var array
     */
    protected static array $route = [];

    /**
     * Returns request string
     * @return string
     */

    private static function getURI(): string
    {
        return trim($_SERVER['REQUEST_URI'], '/');
    }

    /**
     * add route in table routes
     *
     * @param string $regexp regular expression of route
     * @param array $route array ([controller, action, params])
     */

    public static function add(string $regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    /**
     * return table routes
     *
     * @return array
     */
    public static function getRoutes(): array
    {
        return self::$routes;
    }

    /**
     * return current route (controller, action, [params])
     *
     * @return array
     */

    public static function getRoute(): array
    {
        return self::$route;
    }
    /**
     * search URL in routes table
     * @return bool
     */
    public static function matchRoute(): bool
    {
        $uri = self::getURI();
        foreach (self::$routes as $uriPattern => $route) {
            if (preg_match("~$uriPattern~", $uri, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }
                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    public static function dispatch()
    {
        if (self::matchRoute()) {
            $controller = ucfirst(self::$route['controller']) . 'Controller';
            $controllerFile = '../App' . '/Controllers/' . $controller . '.php';
            require_once($controllerFile);
            $controllerObject = new $controller();
            $action = self::$route['action'];
            if (self::$route['id']) {
                $controllerObject->$action((int) self::$route['id']);
            } else {
                $controllerObject->$action();
            }
        } else {
            throw new PathException('There is no information for this uri');
        }
    }
}