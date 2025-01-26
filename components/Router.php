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
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        $uri = $this->getURI();
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                $segments = explode('/', $internalRoute);

                // Controller nomini olish va 'Controller' qo'shish
                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);

                // Controller namespace'ini to'g'ri sozlash
                $controllerName = 'App\\Controllers\\' . $controllerName;

                // Action nomini olish
                $actionName = 'action' . ucfirst(array_shift($segments));

                // Parametrlarni olish
                $parameters = $segments;

                // Controller faylini tekshirish
                $controllerFile = ROOT . '/app/controllers/' . str_replace('\\', '/', $controllerName) . '.php';

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                } else {
                    // Agar controller fayli topilmasa, xatolikni chiqarish
                    echo "Controller file does not exist: $controllerFile";
                    exit;
                }

                // PDO ulanishini yaratish (yoki mavjud bo'lsa, uni controllerga uzatish)
                $pdo = new \PDO('mysql:host=localhost;dbname=php_chat', 'root', '', [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                ]);

                // Controllerni yaratish va PDO ni uzatish
                $controllerObject = new $controllerName($pdo);

                // Controller metodini chaqirish
                $result = call_user_func_array([$controllerObject, $actionName], $parameters);

                // Agar natija bo'lsa, chiqish
                if ($result != null) {
                    break;
                }
            }
        }
    }
}
