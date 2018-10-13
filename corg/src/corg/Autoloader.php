<?php

namespace corg;

class Autoloader
{
    public function load($className)
    {
        $config = \corg\Config::get('autoload');
        $file = $config['class_path'] . '/' . str_replace('\\', '/', $className) . '.php';

        if (file_exists($file)) {
            require $file;
        } else {
            return false;
        }
    }

    public function register()
    {
        spl_autoload_register([$this, 'load']);
    }
}

$loader = new Autoloader();
$loader->register();
