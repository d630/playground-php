<?php

namespace corg;

class MyException
{
    public function exception($e)
    {
        error_log($e);

        if (is_readable('errors/' . $e->getCode() . '.php')) {
            readfile('errors/' . $e->getCode() . '.php');
        } else {
            readfile('errors/500.php');
        }

        exit(1);
    }

    public function register()
    {
        set_exception_handler([$this, 'exception']);
    }
}

$myException = new MyException();
$myException->register();
