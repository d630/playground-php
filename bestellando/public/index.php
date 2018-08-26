<?php
require_once '../src/bestellando/Config.php';
\bestellando\Config::setDirectory('../config');

$config = \bestellando\Config::get('autoload');
require_once $config['class_path'] . '/bestellando/Autoloader.php';

if (!isset($_SERVER['PATH_INFO']) ||
    empty($_SERVER['PATH_INFO']) ||
    $_SERVER['PATH_INFO'] == '/') {
    $route = 'select';
} else {
    $route = $_SERVER['PATH_INFO'];
}

$router = new \bestellando\Router();
$router->start($route);
?>
