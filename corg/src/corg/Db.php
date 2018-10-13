<?php

namespace corg;

class Db
{
    private static $instance;
    private $connection;

    private function __construct()
    {
        $config = \corg\Config::get('database');

        //TODO: NULL_EMPTY_STRING does not work
        $this->connection = new \PDO(
            $config['dsn'] ,
            $config['user'],
            $config['password'],
            $config['pdo']
        );
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();

        }

        return static::$instance->getConnection();
    }
}
