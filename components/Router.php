<?php


class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    private function getURI()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = explode('?', $uri)[0];
        return trim($uri, '/');
    }

    public function run()
    {
        $uri = $this->getURI();
    
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                if (is_callable($path)) {
                    echo "Error: Route '$uriPattern' has a callable path, which is not supported in this context.";
                    exit;
                }
    
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
    
                $segments = explode('/', $internalRoute);
                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);
                $controllerNamespace = 'App\\Controllers\\' . $controllerName;
                $actionName = array_shift($segments);
                $parameters = $segments;
    
                $controllerFile = ROOT . '/app/controllers/' . $controllerName . '.php';
    
                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                } else {
                    echo "Controller file does not exist: $controllerFile";
                    exit;
                }
    
                $pdo = new \PDO('pgsql:host=localhost;port=5432;dbname=php_chat', 'root', 'secret', [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                ]);
                
    
                $controllerObject = new $controllerNamespace($pdo);
    
                if (!empty($_GET)) {
                    $parameters = array_merge($parameters, $_GET);
                }
    
                $result = call_user_func_array([$controllerObject, $actionName], $parameters);
    
                if ($result != null) {
                    break;
                }
            }
        }
    }
    
}
