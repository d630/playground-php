<?php
namespace bestellando;

class Router
{
    public function start($route)
    {
        if ($route{0} == '/') {
            $route = substr($route, 1);
        }

        $method = [new \bestellando\Controller\Order(), $route . 'Action'];

        if (is_callable($method)) {
            return $method();
        }

        require 'error.php';
    }
}
?>
