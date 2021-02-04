<?php

namespace App\Tools;

use App\tools\Errors\PathException;

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = require '../App/config/routes.php';
        $this->routes = $routesPath;
    }

    /**
     * Returns request string
     * @return string
     */
    private function getURI(): string
    {
        return trim($_SERVER['REQUEST_URI'], '/');
    }

    public function run()
    {
        // let's get uri
        $uri =  $this->getURI();
        // find out if we have this request in routes
        foreach ($this->routes as $uriPattern => $path) {
            // find if request is in array of routes
            if (preg_match("~$uriPattern~", $uri, $matches, PREG_UNMATCHED_AS_NULL)) {
                if ($uriPattern == '' && $uri !== '') {
                    throw new PathException('You put a wrong path! There is no information to this uri' . "$uri");
                } else {
                    // example :
                    // preg_replace($uriPattern='product/([0-9])+',$path='product/view/$1',$uri='product/3')
                    $internalRoute = preg_replace("~$uriPattern~", $path, $uri, 1);
                    $uri = explode('/', $uri);
                    $segments = explode('/', $internalRoute);
                    // find out name for Controller
                    $controllerName = array_shift($segments) . 'Controller';
                    $controllerName = ucfirst($controllerName);
                    // find out action for this Controller
                    $actionName = 'action' . ucfirst(array_shift($segments));
                    while (!empty($segments)) {
                        $parametr = (int) array_shift($segments);
                        if (!$parametr) {
                            throw new PathException('There is no information for this uri');
                        }
                    }
                    // require file with ControllerName
                    $controllerFile = '../App' . '/Controllers/' . $controllerName . '.php';
                    require_once($controllerFile);
                    // create instance of this class and call his method action
                    $controllerObject = new $controllerName();
                    $controllerObject->$actionName($parametr);
                }
            }
        }
    }
}