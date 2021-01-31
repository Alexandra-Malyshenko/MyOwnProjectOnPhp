<?php


namespace App\tools;

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = require ('../App/config/routes.php');
        $this->routes = $routesPath;
    }

    /**
     * Returns request string
     * @return string
     */
    private function getURI()
    {
        return trim($_SERVER['REQUEST_URI'], '/');
    }

    public function run()
    {
        // let's get uri
        $uri = $this->getURI();

        // find out if we have this request in routes
        foreach ($this->routes as $uriPattern => $path)
        {
            // find if request is in array of routes
            if (preg_match("~$uriPattern~", $uri))
            {
                // example :
                // preg_replace($uriPattern='product/([0-9])+',$path='product/view/$1',$uri='product/3')

                $internalRoute = preg_replace("~$uriPattern~", $path, $uri );
                $segments = explode('/', $internalRoute);

                // find out name for Controller
                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);
                // find out action for this Controller
                $actionName = 'action' . ucfirst(array_shift($segments));
                $params = $segments;
//                echo  '$controllerName = ' . $controllerName;
//                echo  '$actionName = ' . $actionName;
//                echo  '$params = ' . $params;

                // require file with ControllerName
                $controllerFile = '../App' . '/Controllers/' . $controllerName . '.php';
                if (file_exists($controllerFile)) {
                    require_once($controllerFile);

                }
                // create instance of this class and call his method action
                $controllerObject = new $controllerName();
                $result = $controllerObject->$actionName($params);

                if ($result != null ) {
                    break;
                }
                break;
            }
        }

    }
}