<?php

session_name('corg');
session_start();

require_once '../vendor/autoload.php';
require_once '../config/error.php';
require_once '../config/file.php';

require_once '../src/corg/Config.php';
\corg\Config::setDirectory('../config');

$config = \corg\Config::get('autoload');
require_once $config['class_path'] . '/corg/Autoloader.php';
require_once $config['class_path'] . '/corg/MyException.php';

$route = null;
if(isset($_SESSION['employee_id'])) {
    if (isset($_SERVER['PATH_INFO'])) {
        $route = $_SERVER['PATH_INFO'];
    }
} else {
    if ($_SERVER['PATH_INFO'] == '/auth/register') {
        $route = '/auth/register';
    } else {
        $route = '/auth/login';
    }
}

$router = new \corg\Router();
$router->start($route);
