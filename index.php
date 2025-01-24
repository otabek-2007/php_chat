<?php

// 1. All Settings
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define the root directory
define('ROOT', dirname(__FILE__));

// Register the autoloader before any class is used
spl_autoload_register(function ($class) {
    $path = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

// Include the Router class
require_once(ROOT . '/components/Router.php');

// Instantiate and run the router
$router = new Router();
$router->run();
